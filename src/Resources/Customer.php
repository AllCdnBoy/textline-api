<?php

namespace Textline\Resources;

use Textline\Http\Client as HttpClient;

class Customer extends Resource
{
    /**
     * @var string
     */
    protected $uuid;

    public function __construct(HttpClient $client, string $uuid)
    {
        $this->uuid = $uuid;

        parent::__construct($client);
    }

    public function retrieve()
    {
        $response = $this->client
                         ->get("api/customer/{$this->uuid}.json")
                         ->getContent();

        return $response;
    }

    public function update(array $body = [])
    {
        $response = $this->client
                         ->put("api/customer/{$this->uuid}.json", $body)
                         ->getContent();

        return $response;
    }
}

