<?php

namespace RIPS\Test\Requests;

use RIPS\Connector\API;
use RIPS\Connector\Requests\OAuth2\AccessTokenRequest;
use RIPS\Connector\Requests\OAuth2\LoginCheckRequest;
use RIPS\Test\TestCase;
use RIPS\Connector\Requests\LogRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class LoginCheckRequestTest extends TestCase
{
    /**
     * @var LoginCheckRequest
     */
    protected $loginCheckRequest;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"user": {"id": 1}}'),
        ]));

        $this->loginCheckRequest = new LoginCheckRequest($this->client);
    }

    /**
     * @test
     */
    public function loginWithoutOauth2()
    {
        /** @var \stdClass $response */
        $response = $this->loginCheckRequest->isLoggedIn();

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertTrue($response);
    }
}
