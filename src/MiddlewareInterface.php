<?php

namespace Acme\Api;

/**
 * Interface for middleware
 */
interface MiddlewareInterface
{
    /**
     * Process a request and returns a response.
     *
     * @param Request           $request  The HTTP request
     * @param DelegateInterface $delegate A delegate
     *
     * @return Response The HTTP response
     */
    public function process(Request $request, DelegateInterface $delegate): Response;
}
