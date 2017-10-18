<?php

namespace RIPS\Test\Requests\Application\Scan;

use RIPS\Connector\Requests\Application\Scan\ClassRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ClassRequestsTest extends TestCase
{
    /** @var ClassRequests */
    protected $classRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->classRequests = new ClassRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->classRequests->getAll(1, 2, [
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
        $this->assertEquals('/applications/1/scans/2/classes', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->classRequests->getById(1, 2, 3);
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/classes/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->classRequests->create(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/classes/batches', $request->getUri()->getPath());
        $this->assertEquals('class[test]=input', $body);
    }
}
