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
    public function newData()
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
            'status_code' => $this->getData()->getStatusCode(),
            'headers'     => $this->getData()->getHeaders(),
            'body'        => $this->getData()->getBody(),
        ];
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public function fromArray($data)
    {
        return $this->setData(new Response($data['status_code'], $data['headers'], $data['body']));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getData()->getBody();
    }
}
