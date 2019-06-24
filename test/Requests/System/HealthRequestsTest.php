<?php

namespace RIPS\Test\Requests\System;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use RIPS\Connector\Requests\System\HealthRequests;
use RIPS\Test\TestCase;

class HealthRequestsTest extends TestCase
{
    /** @var HealthRequests */
    protected $healthRequests;

    public function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->healthRequests = new HealthRequests($this->client);
    }

    /**
     * @test
     */
    public function get()
    {
        $response = $this->healthRequests->get();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/systems/health', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
