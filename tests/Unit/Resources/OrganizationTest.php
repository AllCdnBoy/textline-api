<?php

namespace Tests;

use Textline\Resources\Organization;
use Textline\Http\Client;
use Textline\Http\Response;

class OrganizationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->client = $this->mock(Client::class);
        $this->organization = new Organization($this->client);
        $this->response = $this->mock(Response::class);
    }

    /** @test */
    public function it_can_get_the_organization_details()
    {
        $this->client
            ->shouldReceive('get')
            ->once()
            ->with('organization.json', [
                'foo' => 'bar'
            ])
            ->andReturn($this->response);

        $this->response
            ->shouldReceive('getContent')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->organization->get(['foo' => 'bar']));
    }
}
