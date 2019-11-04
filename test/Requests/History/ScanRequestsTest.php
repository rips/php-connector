<?php

namespace RIPS\Test\Requests\History;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use RIPS\Connector\Requests\History\ScanRequests;
use RIPS\Test\TestCase;

class ScanRequestsTest extends TestCase
{
    /** @var ScanRequests */
    protected $historyScanRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->historyScanRequests = new ScanRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->historyScanRequests->getAll();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/histories/scans', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->historyScanRequests->getById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/histories/scans/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function getStats()
    {
        $response = $this->historyScanRequests->getStats();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/histories/scans/stats', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
