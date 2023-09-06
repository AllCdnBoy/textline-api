<?php

namespace Tests;

use Tests\Traits\MocksHttp;
use Textline\Client;
use Textline\Exceptions\AuthenticationException;
use Textline\Http\Response;

class ClientTest extends TestCase
{
    use MocksHttp;

    private function authResponse()
    {
        $authResponse = '{"user":{"avatar_url":null,"name":"John Smith","on_call":true,"username":"johnsmith","uuid":"uuid-123"},"access_token":{"token":"token-123"}}';

        return new Response(201, $authResponse);
    }

    /** @test */
    public function it_can_list_conversations()
    {
        $conversationsList = '{"conversations":[{"reachable":true,"resolved":false,"uuid":"uuid-123","customer":{"avatar_url":null,"blocked":false,"facebook_id":null,"name":"xxx-xxx-xxx","notes":"","reachable_by_sms":true,"tags":[],"uuid":"uuid-123","explicit_name":null,"custom_fields":[],"edit_url":"https://application.textline.com/customer/xxx","phone_number":{"display_phone_number":"xxx-xxx-xxx","location":"New York, US"}},"customer_waiting_since":1550419252,"last_post_at":1550419252,"conversation_endpoint":"https://application.textline.com/conversation/uuid.json","escalated":true,"preview":"Ok great","group_uuid":"xxx-xxx-xxx","status_data":{"status":"Waiting","detail":"1 hour"},"assigned_user":null,"private_to_user":false,"shareable_link":"https://application.textline.com/c/uuid"}]}';

        $handler = $this->getMockHandler(
            $this->authResponse(),
            new Response(200, $conversationsList)
        );

        $client = new Client('a', 'b', 'c', null, [], null, ['handler' => $handler]);

        $list = $client->conversations()->list();

        $this->assertEquals($list, json_decode($conversationsList));
    }

    /**
     * @vcr invalid_key.yml
     * @test
     */
    public function it_throws_an_exception_for_incorrect_api_key()
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('{"message":"Invalid API Key"}');

        $client = new Client('a', 'b', 'c');
    }

    /**
     * @test
     */
    public function it_throws_an_exception_for_incorrect_token()
    {
        $tokenResponse = '{"message":"Invalid access token"}';
        $handler = $this->getMockHandler(
            new Response(401, $tokenResponse)
        );
        $client = new Client('a', 'b', 'c', 'notatoken', [], null, ['handler' => $handler]);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('{"message":"Invalid access token"}');

        $list = $client->conversations()->list();
    }

    /** @test */
    public function it_will_return_a_nice_response_for_resource_not_found_errors()
    {
        $handler = $this->getMockHandler(
            new Response(404, '')
        );

        $client = new Client('a', 'b', 'c', 'd', [], null, ['handler' => $handler]);

        $conversation = $client->conversation()->retrieve('123');

        $this->assertEquals($conversation, (object) [
            'success' => false,
            'error' => true,
            'message' => 'Resource not found'
        ]);
    }
}
