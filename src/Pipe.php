<?php

namespace Acme\Api;

/**
 * A simple stack of middlewares
 */
class Pipe implements MiddlewareInterface
{
    /**
     * @var MiddlewareInterface[] A stack of middlewares
     */
    protected $stack;

    /**
     * Constructor.
     *
     * @param MiddlewareInterface[] ...$middlewares A list of middlewares
     */
    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->stack = $middlewares;
    }

    public function process(Request $request, DelegateInterface $delegate): Response
    {
        if (empty($this->stack)) {
            return $delegate->process($request);
        }

        return array_shift($this->stack)->process($request, new class($this, $delegate) implements DelegateInterface {

                protected $middleware;
                protected $delegate;

                public function __construct(MiddlewareInterface $middleware, DelegateInterface $delegate)
                {
                    $this->middleware = $middleware;
                    $this->delegate = $delegate;
                }

                public function process(Request $request): Response
                {
                    return $this->middleware->process($request, $this->delegate);
                }
            }
        );
    }
}
