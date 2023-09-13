<?php

namespace Textline\Resources;

use Textline\Http\Client as HttpClient;

class Conversation extends Resource
{
    public function __construct(HttpClient $client, protected string $uuid)
    {
        parent::__construct($client);
    }

    public function retrieve(array $query = [])
    {
        return $this->client->get("api/conversation/{$this->uuid}.json", $query)->getContent();
    }

    public function message(array $body = [])
    {
        return $this->client->post("api/conversation/{$this->uuid}.json", $body)->getContent();
    }

    public function scheduleMessage(int $timestamp, string $body)
    {
        return $this->client
            ->post("api/conversation/{$this->uuid}/schedule.json", [
                'timestamp' => $timestamp,
                'comment' => [
                    'body' => $body
                ]
            ])
            ->getContent();
    }

    public function resolve()
    {
        return $this->client->post("api/conversation/{$this->uuid}/resolve.json")->getContent();
    }

    public function transfer()
    {
        return $this->client->post("api/conversation/{$this->uuid}/transfer.json")->getContent();
    }
}
