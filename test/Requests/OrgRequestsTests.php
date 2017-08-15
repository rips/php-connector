<?php

namespace RIPS\Test\Requests;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\OrgRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Middleware;

class OrgRequestsTests extends TestCase
{
    // @var OrgRequests
    protected $orgRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->orgRequests = new OrgRequests($this->client);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->orgRequests->getById(1);
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/organisations/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->orgRequests->update(1, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/organisations/1', $request->getUri()->getPath());
        $this->assertEquals('organisation[test]=input', $body);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->orgRequests->create(['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/organisations', $request->getUri()->getPath());
        $this->assertEquals('organisation[test]=input', $body);
    }
}
