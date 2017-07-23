<?php

namespace Acme\Api;

/**
 * A really basic printable HTTP response
 */
class Response
{
    /**
     * @var array The response body
     */
    protected $body;

    /**
     * @var int The status code
     */
    protected $code;

    /**
     * Constructor.
     *
     * @param array|null $body The body of the response
     * @param int        $code The status code
     */
    public function __construct(array $body = null, int $code = 200)
    {
        $this->body = $body;
        $this->code = $code;
    }

    /**
     * Returns the string representation of the response.
     *
     * @return string The string representation
     */
    public function __toString()
    {
        http_response_code($this->code);
        header('Content-Type: application/json');

        return json_encode($this->body ?: '');
    }
}
