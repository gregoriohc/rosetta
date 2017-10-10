<?php

namespace Ghc\Rosetta\Messages;

use GuzzleHttp\Psr7\Response;

/**
 * @property Response $data
 */
class HttpResponse extends Message
{
    /**
     * @return string
     */
    public function new()
    {
        return new Response();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'status_code' => $this->get()->getStatusCode(),
            'headers' => $this->get()->getHeaders(),
            'body' => $this->get()->getBody(),
        ];
    }

    /**
     * @param array $data
     * @return self
     */
    public function fromArray($data)
    {
        return $this->set(new Response($data['status_code'], $data['body'], $data['headers']));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->get()->getBody();
    }
}