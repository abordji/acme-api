<?php

namespace Acme\Api;

/**
 * A simple router implementation based on regular expressions
 */
class Router implements MiddlewareInterface
{
    /**
     * @var array A list of routes
     */
    protected $routes = [];

    /**
     * Adds a route.
     *
     * @param string              $method  The HTTP method
     * @param string              $pattern The pattern to match
     * @param MiddlewareInterface $action  The action to perform
     */
    public function add(string $method, string $pattern, MiddlewareInterface $action)
    {
        $this->routes[] = [$method, $pattern, $action];
    }

    public function process(Request $request, DelegateInterface $delegate): Response
    {
        foreach ($this->routes as list($method, $pattern, $action)) {

            if ($request->getMethod() === $method
                && 1 === preg_match($pattern, $request->getRequestUri(), $attributes)) {

                array_shift($attributes);

                return $action->process($request->withAttributes($attributes), $delegate);
            }
        }

        return $delegate->process($request);
    }
}
