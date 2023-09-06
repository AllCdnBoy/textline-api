<?php

namespace Tests;

use Textline\Resources\Customers;
use Textline\Http\Client;
use Textline\Http\Response;

class Test extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->client = $this->mock(Client::class);
        $this->customers = new Customers($this->client);
        $this->response = $this->mock(Response::class);
    }

    /** @test */
    public function it_can_return_a_list_of_customers()
    {
        $this->client
            ->shouldReceive('get')
            ->once()
            ->with('customers.json', [
                'foo' => 'bar'
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->customers->get(['foo' => 'bar']));
    }

    /** @test */
    public function it_can_create_a_new_customer()
    {
        $num = '123';

        $this->client
            ->shouldReceive('post')
            ->once()
            ->with('customers.json', [
                'phone_number' => $num,
                'foo' => 'bar'
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->customers->create($num, ['foo' => 'bar']));
    }
}
