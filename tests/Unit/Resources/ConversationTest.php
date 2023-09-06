<?php

namespace Tests;

use Textline\Resources\Conversation;
use Textline\Http\Client;
use Textline\Http\Response;

class ConversationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->uuid = '1';
        $this->client = $this->mock(Client::class);
        $this->conversation = new Conversation($this->client, $this->uuid);
        $this->response = $this->mock(Response::class);
    }

    /** @test */
    public function it_can_retrieve_a_conversation()
    {
        $this->client
            ->shouldReceive('get')
            ->once()
            ->with('conversation/1.json', [
                'foo' => 'bar'
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->conversation->retrieve(['foo' => 'bar']));
    }

    /** @test */
    public function it_can_message_a_conversation()
    {
        $this->client
            ->shouldReceive('post')
            ->once()
            ->with('conversation/1.json', [
                'foo' => 'bar'
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->conversation->message(['foo' => 'bar']));
    }

    /** @test */
    public function it_can_schedule_a_message_to_a_conversation()
    {
        $time = 456;
        $body = 'foo';

        $this->client
            ->shouldReceive('post')
            ->once()
            ->with('conversation/1/schedule.json', [
                'timestamp' => 456,
                'comment' => [
                    'body' => 'foo'
                ]
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->conversation->scheduleMessage($time, $body));
    }

    /** @test */
    public function it_can_transfer_a_conversation()
    {
        $this->client
            ->shouldReceive('post')
            ->once()
            ->with('conversation/1/transfer.json')
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->conversation->transfer());
    }

    /** @test */
    public function it_can_resolve_a_conversation()
    {
        $this->client
            ->shouldReceive('post')
            ->once()
            ->with('conversation/1/resolve.json')
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->conversation->resolve());
    }
}
