<?php

namespace Acme\Api;

/**
 * An really basic HTTP request
 */
class Request
{
    /**
     * @var string The HTTP method
     */
    protected $method;

    /**
     * @var string The request URI
     */
    protected $requestUri;

    /**
     * @var array The request attributes
     */
    protected $attributes;

    /**
     * Constructor.
     *
     * @param string $method     The HTTP method
     * @param string $requestUri The request URI
     * @param array  $attributes The attributes related to the request
     */
    public function __construct(string $method, string $requestUri, array $attributes = [])
    {
        $this->method = $method;
        $this->requestUri = $requestUri;
        $this->attributes = $attributes;
    }

    /**
     * Returns the HTTP method.
     *
     * @return string The HTTP method
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns the request URI.
     *
     * @return string The request URI
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     * Returns a new request with the given attributes.
     *
     * @param array $attributes The attributes to bind to the request
     *
     * @return Request The created request
     */
    public function withAttributes(array $attributes): self
    {
        $request = clone $this;
        $request->attributes = $attributes;

        return $request;
    }

    /**
     * Returns the attributes related to the query.
     *
     * @return array The attributes
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
