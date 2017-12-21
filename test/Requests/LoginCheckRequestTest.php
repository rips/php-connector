<?php

namespace RIPS\Test\Requests;

use RIPS\Connector\Requests\StatusRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class LoginCheckRequestTest extends TestCase
{
    /**
     * @var StatusRequests
     */
    protected $statusRequest;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"user": {"id": 1}}'),
        ]));

        $this->statusRequest = new StatusRequests($this->client);
    }

    /**
     * @test
     */
    public function loginWithoutOauth2()
    {
        $response = $this->statusRequest->isLoggedIn();
        $this->container[0]['request'];

        $this->assertTrue($response);
    }
}
