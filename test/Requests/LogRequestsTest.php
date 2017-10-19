<?php

namespace RIPS\Test\Requests;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\LogRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class LogRequestsTest extends TestCase
{
    /** @var LogRequests */
    protected $logRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->logRequests = new LogRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        /** @var \stdClass $response */
        $response = $this->logRequests->getAll([
            'greaterThan' => [
                'id' => 1,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/logs', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->logRequests->getById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/logs/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->logRequests->create(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/logs', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('log[test]=input', $body);
    }

    /**
     * @test
     */
    public function delete()
    {
        $this->logRequests->delete([
            'notEqual' => [
                'name' => 'test',
            ],
            'greaterThan' => [
                'id' => 1,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/logs', $request->getUri()->getPath());
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=1', $queryString);
    }
}
