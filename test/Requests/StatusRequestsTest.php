<?php

namespace RIPS\Test\Requests;

use RIPS\Connector\Requests\StatusRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class StatusRequestsTest extends TestCase
{
    /** @var StatusRequests */
    protected $statusRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->statusRequests = new StatusRequests($this->client);
    }

    /**
     * @test
     */
    public function getStatus()
    {
        $response = $this->statusRequests->getStatus();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('/status', $request->getUri()->getPath());
    }
}
