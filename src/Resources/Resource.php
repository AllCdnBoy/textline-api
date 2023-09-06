<?php

namespace Textline\Resources;

use Textline\Http\Client as HttpClient;

abstract class Resource
{
    /**
     * @var HttpClient $client
     */
    protected $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }
}
