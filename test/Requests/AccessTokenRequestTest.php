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

class AccessTokenRequestTest extends TestCase
{
    /**
     * @var AccessTokenRequest
     */
    protected $accessTokenRequest;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->accessTokenRequest = new AccessTokenRequest($this->client);
    }

    /**
     * @test
     */
    public function getAccessTokens()
    {
        $this->accessTokenRequest->getTokens();

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        var_dump($request->getUri());
    }

}
