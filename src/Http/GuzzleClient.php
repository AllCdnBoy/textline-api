<?php

namespace Textline\Http;

use GuzzleHttp\Client as GuzzleBaseClient;
use Textline\Exceptions\AuthenticationException;

class GuzzleClient implements Client
{
    protected GuzzleBaseClient $client;

    public function __construct(protected string $baseUri, protected array $headers = [], protected array $config = [])
    {
        $this->client = new GuzzleBaseClient(array_merge($config, [
            'base_uri' => $this->baseUri,
            'headers' => $this->headers,
            'http_errors' => false,
        ]));
    }

    private function request(string $method, string $url, array $body = [], array $headers = [], array $query = []): Response|AuthenticationException
    {
        $requestParams = [
            'json' => $body,
            'headers' => array_merge($this->headers, $headers),
            'query' => $query,
        ];

        $res = $this->client->request(strtoupper($method), $url, $requestParams);

        $code = $res->getStatusCode();
        $resBody = $res->getBody()->getContents();

        switch ($code) {
            // catch authentication exceptions as the rest of the app will fail
            case 401:
                throw new AuthenticationException($resBody);
            case 404:
                $resBody = json_encode([
                    'success' => false,
                    'error' => true,
                    'message' => 'Resource not found'
                ]);
                break;

            case 400:
                $resBody = json_encode(array_merge([
                    'success' => false,
                    'error' => true,
                    'message' => 'Error in fields.  See Error list',
                ], (array)json_decode($resBody)));
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

    public function post(string $url, array $body = [], array $headers = []): Response
    {
        return $this->request('post', $url, $body, $headers);
    }

    public function put(string $url, array $body = [], array $headers = []): Response
    {
        return $this->request('put', $url, $body, $headers);
    }

    public function get(string $url, array $query = [], array $headers = []): Response
    {
        return $this->request('get', $url, [], $headers, $query);
    }

    public function setHeader(string $header, string $value): static
    {
        $this->headers[$header] = $value;

        return $this;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
