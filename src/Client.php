<?php

namespace Textline;

use Textline\Http\Client as HttpClient;
use Textline\Http\GuzzleClient;
use Textline\Resources\{Conversation, Conversations, Customer, Customers, Organization};

class Client
{

    protected string $baseUri = 'https://application.textline.com/';

    public function __construct(
        protected string      $email,
        protected string      $password,
        protected string      $apiKey,
        protected ?string     $token = null,
        protected array       $headers = [],
        protected ?HttpClient $client = null,
        array                 $clientConfig = []
    )
    {
        $this->client = $client ?? new GuzzleClient($this->baseUri, $this->headers, $clientConfig);

        $token ? $this->setAuth($this->token) : $this->auth();
    }

    public function auth(): static
    {
        $response = $this->client->post('auth/sign_in.json', [
            'user' => [
                'email' => $this->email,
                'password' => $this->password,
            ],
            'api_key' => $this->apiKey
        ]);

        $this->token = $response->getContent()->access_token->token;

        $this->setAuth($this->token);

        return $this;
    }

    private function setAuth(string $token)
    {
        $this->client->setHeader('X-TGP-ACCESS-TOKEN', $token);

        return $this;
    }

    public function conversations(): Conversations
    {
        return new Conversations($this->client);
    }

    public function conversation(string $uuid): Conversation
    {
        return new Conversation($this->client, $uuid);
    }

    public function customers(): Customers
    {
        return new Customers($this->client);
    }

    public function customer(string $uuid): Customer
    {
        return new Customer($this->client, $uuid);
    }

    public function organization(): Organization
    {
        return new Organization($this->client);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}
