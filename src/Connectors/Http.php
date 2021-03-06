<?php

namespace Ghc\Rosetta\Connectors;

use Exception;
use Ghc\Rosetta\Messages\HttpResponse;
use gomes81\GuzzleHttp\Subscriber\CookieAuth;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use kamermans\OAuth2\OAuth2Middleware;

class Http extends Connector
{
    /**
     * Basic HTTP auth.
     * Config example: ['type' => self::AUTH_BASIC, 'username' => 'USER', 'password' => 'PASSWD'].
     */
    const AUTH_BASIC = 'basic';

    /**
     * Digest HTTP auth.
     * Config example: ['type' => self::AUTH_DIGEST, 'username' => 'USER', 'password' => 'PASSWD'].
     */
    const AUTH_DIGEST = 'digest';

    /**
     * Microsoft NTLM HTTP auth.
     * Config example: ['type' => self::AUTH_NTLM, 'username' => 'USER', 'password' => 'PASSWD'].
     */
    const AUTH_NTLM = 'ntlm';

    /**
     * Oauth1 auth.
     * Config example: ['type' => self::AUTH_OAUTH1, 'consumer_key' => 'my_key', 'consumer_secret' => 'my_secret', 'token' => 'my_token', 'token_secret' => 'my_token_secret'].
     *
     * @link https://github.com/guzzle/oauth-subscriber
     */
    const AUTH_OAUTH1 = 'oauth1';

    /**
     * Oauth2 auth.
     * Config example: ['type' => self::AUTH_OAUTH2, "uri" => "access_token_uri", "grant_type" => "client_credentials", "client_id" => "my_client_id", "client_secret" => "my_client_secret",]
     * Grant types: authorization_code, client_credentials, password_credentials, refresh_token.
     *
     * @link https://github.com/kamermans/guzzle-oauth2-subscriber
     */
    const AUTH_OAUTH2 = 'oauth2';

    /**
     * Cookie auth.
     * Config example: ['type' => self::AUTH_COOKIE, 'uri' => 'form_uri', 'fields' => ['username' => 'USER', 'password' => 'PASSWD', 'foo' => 'bar'], 'method' => 'POST', 'cookies' => 'cookie_string_or_cookie_string_array_or_cookie_jar'].
     */
    const AUTH_COOKIE = 'cookie';

    /**
     * Custom handler stack auth.
     * Config example: ['type' => self::AUTH_CUSTOM, 'handler' => $handlerStack', 'auth' => 'authName'].
     */
    const AUTH_CUSTOM = 'custom';

    /**
     * HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Boot Connector.
     */
    protected function boot()
    {
    }

    /**
     * @param Client $client
     *
     * @return Http
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        if (!$this->client) {
            $this->bootClient();
        }

        return $this->client;
    }

    /**
     * @return Client
     */
    public function bootClient()
    {
        if ($authConfig = $this->config->get('auth_config')) {
            $this->config->set('auth_config', null);
            $this->setAuth($authConfig);
        }

        $this->setClient(new Client($this->config->all()));
    }

    /**
     * @param array $config
     *
     * @throws Exception
     *
     * @uses  getClientConfigAuthBasic
     * @uses  getClientConfigAuthDigest
     * @uses  getClientConfigAuthNtlm
     * @uses  getClientConfigAuthOauth1
     * @uses  getClientConfigAuthOauth2
     * @uses  getClientConfigAuthCookie
     * @uses  getClientConfigAuthCustom
     */
    public function setAuth($config = [])
    {
        $type = $config['type'];
        unset($config['type']);

        $method = 'getClientConfigAuth'.ucfirst($type);
        if (!method_exists($this, $method)) {
            throw new Exception("Invalid auth type: $type");
        }

        /** @var array $clientConfig */
        $clientConfig = call_user_func([$this, $method], $config);

        foreach ($clientConfig as $key => $value) {
            $this->setConfig($key, $value);
        }
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function getClientConfigAuthBasic($config = [])
    {
        return [
            'auth' => [
                $config['username'],
                $config['password'],
            ],
        ];
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function getClientConfigAuthDigest($config = [])
    {
        return [
            'auth' => [
                $config['username'],
                $config['password'],
                'digest',
            ],
        ];
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function getClientConfigAuthNtlm($config = [])
    {
        return [
            'auth' => [
                $config['username'],
                $config['password'],
                'ntlm',
            ],
        ];
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function getClientConfigAuthOauth1($config = [])
    {
        $stack = HandlerStack::create();
        $middleware = new Oauth1($config);
        $stack->push($middleware);
        $clientConfig['handler'] = $stack;
        $clientConfig['auth'] = 'oauth';

        return [
            'auth'    => 'oauth',
            'handler' => $stack,
        ];
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function getClientConfigAuthOauth2($config = [])
    {
        $authClient = new Client(['base_uri' => $config['uri']]);
        $grantType = '\\kamermans\\OAuth2\\GrantType\\'.studly_case($config['grant_type']);
        unset($config['uri']);
        unset($config['grant_type']);
        /** @var \kamermans\OAuth2\GrantType\GrantTypeInterface $grant_type */
        $grant_type = new $grantType($authClient, $config);
        $oauth = new OAuth2Middleware($grant_type);
        $stack = HandlerStack::create();
        $stack->push($oauth);

        return [
            'auth'    => 'oauth',
            'handler' => $stack,
        ];
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function getClientConfigAuthCookie($config = [])
    {
        $stack = HandlerStack::create();
        if (!isset($config['cookies'])) {
            $config['cookies'] = null;
        }
        if (!isset($config['method'])) {
            $config['method'] = 'POST';
        }
        $middleware = new CookieAuth(
            $config['uri'],
            $config['fields'],
            $config['method'],
            $config['cookies']
        );
        $stack->push($middleware);

        return [
            'auth'    => 'cookie',
            'handler' => $stack,
        ];
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function getClientConfigAuthCustom($config = [])
    {
        return [
            'auth'    => $config['auth'],
            'handler' => $config['handler'],
        ];
    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return mixed
     */
    public function show($uri, $options = [])
    {
        return new HttpResponse($this->getClient()->request('GET', $uri, $options));
    }

    /**
     * @param string     $uri
     * @param null|mixed $data
     * @param array      $options
     *
     * @return mixed
     */
    public function create($uri, $data = null, $options = [])
    {
        if (!is_null($data)) {
            $options['form_params'] = $data;
        }

        return new HttpResponse($this->getClient()->request('POST', $uri, $options));
    }

    /**
     * @param string     $uri
     * @param null|mixed $data
     * @param array      $options
     *
     * @return mixed
     */
    public function update($uri, $data = null, $options = [])
    {
        if (!is_null($data)) {
            $options['form_params'] = $data;
        }

        return new HttpResponse($this->getClient()->request('PATCH', $uri, $options));
    }

    /**
     * @param string     $uri
     * @param null|mixed $data
     * @param array      $options
     *
     * @return mixed
     */
    public function replace($uri, $data = null, $options = [])
    {
        if (!is_null($data)) {
            $options['form_params'] = $data;
        }

        return new HttpResponse($this->getClient()->request('PUT', $uri, $options));
    }

    /**
     * @param string $uri
     * @param array  $options
     *
     * @return mixed
     */
    public function delete($uri, $options = [])
    {
        return new HttpResponse($this->getClient()->request('DELETE', $uri, $options));
    }
}
