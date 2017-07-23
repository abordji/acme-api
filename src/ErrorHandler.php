<?php

namespace Acme\Api;

use Acme\Api\Exception\NotFoundException;

/**
 * A basic error handler
 */
class ErrorHandler implements MiddlewareInterface
{
    public function process(Request $request, DelegateInterface $delegate): Response
    {
        try {
            return $delegate->process($request);
        } catch (NotFoundException $ex) {
            return new Response(['error' => $ex->getMessage()], 404);
        } catch (\Throwable $ex) {
            return new Response(['error' => 'internal server error'], 500);
        }
    }
}
