<?php

namespace Tests\Traits;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Textline\Http\Response;

trait MocksHttp
{
    /**
     * Get guzzle mock handler for a variable amount of responses
     *
     * @param array $responses
     */
    public function getMockHandler(Response ...$responses)
    {
        $mock = new MockHandler(
            array_map(
                function ($response) {
                    return new Psr7Response(
                        $response->getStatusCode(),
                        $response->getHeaders(),
                        $response->getRawContent()
                    );
                },
                $responses
            )
        );

        $handler = HandlerStack::create($mock);

        return $handler;
    }
}
