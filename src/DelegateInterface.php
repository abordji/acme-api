<?php

namespace Acme\Api;

/**
 * Interface for delegate
 */
interface DelegateInterface
{
    /**
     * Process a request and returns a response.
     *
     * @param Request $request The HTTP request
     *
     * @return Response The HTTP response
     */
    public function process(Request $request): Response;
}
