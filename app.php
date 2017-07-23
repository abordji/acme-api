<?php

spl_autoload_register(function ($class) {
    $filename = 'src/' . strtr(substr($class, strlen('Acme\Api')), '\\', '/') . '.php';
    if (!file_exists($filename)) {
        http_response_code(500);
        die();
    }

    require $filename;
});

use Acme\Api\Action;
use Acme\Api\Request;
use Acme\Api\Repository;
use Acme\Api\Response;
use Acme\Api\ErrorHandler;
use Acme\Api\Router;
use Acme\Api\Pipe;
use Acme\Api\DelegateInterface;

$repository = new Repository(new PDO('mysql:dbname=my_database;host=my_host', 'my_username', 'my_password'));

$router = new Router();
$router->add('GET',    '#^/users/(\d)$#',             new Action\FindUser($repository));
$router->add('GET',    '#^/tracks/(\d)$#',            new Action\FindTrack($repository));
$router->add('GET',    '#^/users/(\d)/tracks$#',      new Action\FindUserTracks($repository));
$router->add('POST',   '#^/users/(\d)/tracks/(\d)$#', new Action\AddUserTrack($repository));
$router->add('DELETE', '#^/users/(\d)/tracks/(\d)$#', new Action\RemoveUserTrack($repository));

$pipe = new Pipe(new ErrorHandler(), $router);

$request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

echo $pipe->process($request, new class implements DelegateInterface {
    public function process(Request $request): Response
    {
        return new Response(['error' => 'resource not found'], 404);
    }
});
