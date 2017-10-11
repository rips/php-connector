<?php

namespace RIPS\Test\Requests\Application;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\Custom\SinkRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class SinkRequestsTest extends TestCase
{
    /** @var ScanRequests */
    protected $sinkRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->sinkRequests = new SinkRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->sinkRequests->getAll(1, 2, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }


    /**
     * @test
     */
    public function getById()
    {
        $response = $this->sinkRequests->getById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $this->sinkRequests->create(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks', $request->getUri()->getPath());
        $this->assertEquals('sink[test]=input', $body);
    }

    /**
     * @test
     */
    public function update()
    {
        $this->sinkRequests->update(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks/3', $request->getUri()->getPath());
        $this->assertEquals('sink[test]=input', $body);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->sinkRequests->deleteAll(1, 2, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->sinkRequests->deleteById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks/3', $request->getUri()->getPath());
    }
}
