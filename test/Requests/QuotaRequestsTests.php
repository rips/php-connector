<?php

namespace RIPS\Test\Requests;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\QuotaRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Middleware;

class QuotaRequestsTests extends TestCase
{
    // @var QuotaRequests
    protected $quotasRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->quotaRequests = new QuotaRequests($this->client);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->quotaRequests->create(['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/quotas', $request->getUri()->getPath());
        $this->assertEquals('quota[test]=input', $body);
    }
}
