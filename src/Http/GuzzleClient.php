<?php

namespace Textline\Http;

use GuzzleHttp\Client as GuzzleBaseClient;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use Textline\Exceptions\ClientException;
use Textline\Exceptions\AuthenticationException;

class GuzzleClient implements Client
{
    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var GuzzleBaseClient
     */
    protected $client;

    public function __construct(string $baseUri, array $headers = [], array $config = [])
    {
        $this->baseUri = $baseUri;
        $this->headers = $headers;
        $this->config = $config;

        $this->client = new GuzzleBaseClient(array_merge($config, [
            'base_uri' => $this->baseUri,
            'headers' => $this->headers,
            'http_errors' => false,
        ]));
    }

    /**
     * Make a request
     *
     * @param string $method
     * @param string $url
     * @param array $body
     * @author Dom Batten <db@mettrr.com>
     */
    private function request(string $method, string $url, array $body = [], array $headers = [], array $query = [])
    {
        $requestParams = [
            'json' => $body,
            'headers' => array_merge($this->headers, $headers),
            'query' => $query,
        ];

        $res = $this->client->request(strtoupper($method), $url, $requestParams);

        $code = $res->getStatusCode();
        $resBody = $res->getBody()->getContents();

        switch ($code)
        {
            // catch authentication exceptions as the rest of the app will fail
            case 401:
                throw new AuthenticationException($resBody);
                break;

            // 404 errors returned in html so make the response a bit more
            // useable
            case 404:
                $resBody = json_encode([
                    'success' => false,
                    'error' => true,
                    'message' => 'Resource not found'
                ]);
                break;

            default:
                break;
        }

        return new Response(
            $code,
            $resBody,
            $res->getHeaders()
        );
    }

    public function post(string $url, array $body = [], array $headers = [])
    {
        return $this->request('post', $url, $body, $headers);
    }

    public function put(string $url, array $body = [], array $headers = [])
    {
        return $this->request('put', $url, $body, $headers);
    }

    public function get(string $url, array $query = [], array $headers = [])
    {
        return $this->request('get', $url, [], $headers, $query);
    }

    public function setHeader(string $header, string $value)
    {
        $this->headers[$header] = $value;

        return $this;
    }

    /**
     * Getter for baseUri
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Getter for headers
     *
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Getter for config
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->config;
    }
}
