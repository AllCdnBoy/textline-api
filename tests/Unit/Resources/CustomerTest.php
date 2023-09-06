<?php

namespace Tests;

use Textline\Resources\Customer;
use Textline\Http\Client;
use Textline\Http\Response;

class Test extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->uuid = '123';
        $this->client = $this->mock(Client::class);
        $this->customer = new Customer($this->client, $this->uuid);
        $this->response = $this->mock(Response::class);
    }

    /** @test */
    public function it_can_retrieve_a_customer()
    {
        $id = '123';

        $this->client
            ->shouldReceive('get')
            ->once()
            ->with("customer/{$id}.json")
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->customer->retrieve());
    }

    /** @test */
    public function it_can_update_a_customer()
    {
        $id = '123';

        $this->client
            ->shouldReceive('put')
            ->once()
            ->with("customer/{$id}.json", [
                'foo' => 'bar'
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->customer->update(['foo' => 'bar']));
    }
}

