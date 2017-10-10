<?php

namespace Ghc\Rosetta\Connectors;

use Ghc\Rosetta\Messages\HttpResponse;
use GuzzleHttp\Client;

class Http extends Connector
{
    /**
     * HTTP client
     *
     * @var Client
     */
    protected $client;

    /**
     * Boot Connector
     */
    protected function boot()
    {
        if (!isset($this->config['client'])) $this->config['client'] = [];

        $this->client = new Client($this->config['client']);
    }


    /**
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    public function show($uri, $options = [])
    {
        return new HttpResponse($this->client->request('GET', $uri, $options));
    }

    /**
     * @param string $uri
     * @param null|mixed $data
     * @param array $options
     * @return mixed
     */
    public function create($uri, $data = null, $options = [])
    {
        if ($data) $options['form_params'] = $data;

        return new HttpResponse($this->client->request('POST', $uri, $options));
    }

    /**
     * @param string $uri
     * @param null|mixed $data
     * @param array $options
     * @return mixed
     */
    public function update($uri, $data = null, $options = [])
    {
        if ($data) $options['form_params'] = $data;

        return new HttpResponse($this->client->request('PATCH', $uri, $options));
    }

    /**
     * @param string $uri
     * @param null|mixed $data
     * @param array $options
     * @return mixed
     */
    public function replace($uri, $data = null, $options = [])
    {
        if ($data) $options['form_params'] = $data;

        return new HttpResponse($this->client->request('PUT', $uri, $options));
    }

    /**
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    public function delete($uri, $options = [])
    {
        return new HttpResponse($this->client->request('DELETE', $uri, $options));
    }
}