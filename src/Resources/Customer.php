<?php

namespace Textline\Resources;

use Textline\Http\Client as HttpClient;

class Customer extends Resource
{
    public function __construct(HttpClient $client, protected string $uuid)
    {
        parent::__construct($client);
    }

    public function retrieve()
    {
        return $this->client
            ->get("api/customer/{$this->uuid}.json")
            ->getContent();
    }

    public function update(array $body = [])
    {
        return $this->client
            ->put("api/customer/{$this->uuid}.json", $body)
            ->getContent();
    }
}

