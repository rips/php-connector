<?php

namespace RIPS\Test\Requests\Application\Scan\Issue;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\Scan\Issue\MarkupRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class MarkupRequestsTest extends TestCase
{
    /** @var MarkupRequests */
    protected $markupRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->markupRequests = new MarkupRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->markupRequests->getAll(1, 2, 3, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/markups', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->markupRequests->getById(1, 2, 3, 4);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/markups/4', $request->getUri()->getPath());
    }
}
