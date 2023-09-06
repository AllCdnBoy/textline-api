<?php

namespace Textline\Resources;

use Textline\Http\Client as HttpClient;

class Conversation extends Resource
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

    public function retrieve(array $query = [])
    {
        $response = $this->client
                         ->get("api/conversation/{$this->uuid}.json", $query)
                         ->getContent();

        return $response;
    }

    public function message(array $body = [])
    {
        $response = $this->client
                         ->post("api/conversation/{$this->uuid}.json", $body)
                         ->getContent();

        return $response;
    }

    public function scheduleMessage(int $timestamp, string $body)
    {
        $response = $this->client
                         ->post("api/conversation/{$this->uuid}/schedule.json", [
                             'timestamp' => $timestamp,
                             'comment' => [
                                 'body' => $body
                             ]
                         ])
                         ->getContent();

        return $response;
    }

    public function resolve()
    {
        $response = $this->client
                         ->post("api/conversation/{$this->uuid}/resolve.json")
                         ->getContent();

        return $response;
    }

    public function transfer()
    {
        $response = $this->client
                         ->post("api/conversation/{$this->uuid}/transfer.json")
                         ->getContent();

        return $response;
    }
}
