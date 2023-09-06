<?php

namespace Tests;

use Textline\Http\Response;

class ResponseTest extends TestCase
{
    /** @test */
    public function a_response_has_a_status_code_and_content()
    {
        $code = 200;
        $contentData = [
            'foo' => 'bar'
        ];
        $content = json_encode($contentData);

        $response = new Response($code, $content);

        $this->assertEquals([
            $code, $contentData
        ], [
            $response->getStatusCode(),
            $response->getContent(true),
        ]);
    }

    /** @test */
    public function it_can_confirm_whether_the_response_was_successful()
    {
        $code = 200;
        $contentData = [
            'content' => 'here'
        ];
        $content = json_encode($contentData);

        $response = new Response($code, $content);

        $this->assertTrue($response->successful());
    }

    /** @test */
    public function it_can_confirm_whether_the_response_was_unsuccessful()
    {
        $code = 400;
        $contentData = [
            'content' => 'here'
        ];
        $content = json_encode($contentData);

        $response = new Response($code, $content);

        $this->assertFalse($response->successful());
    }

    /** @test */
    public function it_can_accept_headers_in_the_constructor()
    {
        $code = 200;
        $contentData = [
            'foo' => 'bar'
        ];
        $content = json_encode($contentData);
        $headers = [
            'a' => 'b'
        ];

        $response = new Response($code, $content, $headers);

        $this->assertEquals($response->getHeaders(), $headers);
    }

    /** @test */
    public function it_can_return_the_raw_content()
    {
        $code = 200;
        $contentData = [
            'foo' => 'bar'
        ];
        $content = json_encode($contentData);

        $response = new Response($code, $content);

        $this->assertEquals($response->getRawContent(), $content);
    }

    /** @test */
    public function it_can_return_content_for_non_json()
    {
        $code = 200;
        $content = 'foo';

        $response = new Response($code, $content);

        $this->assertEquals($response->getContent(), $content);
    }
}
