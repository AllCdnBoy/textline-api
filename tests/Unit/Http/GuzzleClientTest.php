<?php

namespace Tests;

use Textline\Http\GuzzleClient;

class GuzzleClientTest extends TestCase
{
    /** @test */
    public function it_sets_the_base_uri_and_headers_and_config()
    {
        $guzzle = $this->getClient();

        $this->assertEquals($guzzle->getBaseUri(), 'base');
        $this->assertEquals($guzzle->getHeaders(), []);
        $this->assertEquals($guzzle->getConfig(), []);
    }

    /** @test */
    public function it_can_set_a_header()
    {
        $guzzle = $this->getClient();

        $guzzle->setHeader('foo', 'bar');

        $this->assertEquals($guzzle->getHeaders(), [
            'foo' => 'bar'
        ]);
    }

    private function getClient($base = 'base', $headers = [], $config = [])
    {
        $base = 'base';
        $headers = [];
        $config = [];

        $guzzle = new GuzzleClient($base, $headers, $config);

        return $guzzle;
    }
}
