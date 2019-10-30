<?php

namespace RIPS\Test\Requests;

use RIPS\Connector\Requests\MfaRequests;
use RIPS\Test\TestCase;
use RIPS\Connector\Requests\TeamRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class MfaRequestsTest extends TestCase
{
    /** @var MfaRequests */
    protected $mfaRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->mfaRequests = new MfaRequests($this->client);
    }

    /**
     * @test
     */
    public function getSecret()
    {
        $response = $this->mfaRequests->getSecret();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/mfas/secret', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function getToken()
    {
        $response = $this->mfaRequests->getToken(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/mfas/token', $request->getUri()->getPath());
        $this->assertEquals('{"challenge":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function delete()
    {
        $response = $this->mfaRequests->delete(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/mfas/delete', $request->getUri()->getPath());
        $this->assertEquals('{"challenge":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
