<?php

namespace Tests;

use Textline\Resources\Conversations;
use Textline\Http\Client;
use Textline\Http\Response;

class ConversationsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->client = $this->mock(Client::class);
        $this->conversations = new Conversations($this->client);
        $this->response = $this->mock(Response::class);
    }

    /** @test */
    public function it_can_get_conversations()
    {
        $this->client
            ->shouldReceive('get')
            ->once()
            ->with('conversations.json', [
                'foo' => 'bar'
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->conversations->get(['foo' => 'bar']));
    }

    /** @test */
    public function it_can_message_a_phone_number()
    {
        $this->client
            ->shouldReceive('post')
            ->once()
            ->with('conversations.json', [
                'phone_number' => '123',
                'comment' => [
                    'body' => 'foo'
                ]
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->conversations->messageByPhone('123', [
            'comment' => [
                'body' => 'foo'
            ]
        ]));
    }

    /** @test */
    public function it_can_schedule_a_message_by_phone_number()
    {
        $number = '123';
        $time = 456;
        $body = 'foo';

        $this->client
            ->shouldReceive('post')
            ->once()
            ->with('conversations/schedule.json', [
                'timestamp' => 456,
                'phone_number' => '123',
                'comment' => [
                    'body' => 'foo'
                ]
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->conversations->scheduleByPhone($number, $time, $body));
    }
}
