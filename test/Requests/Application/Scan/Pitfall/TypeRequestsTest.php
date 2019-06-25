<?php

namespace RIPS\Test\Requests\Application\Scan\Pitfall;

use RIPS\Connector\Requests\Application\Scan\Pitfall\TypeRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class TypeRequestsTest extends TestCase
{
    /** @var TypeRequests */
    protected $typeRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->typeRequests = new TypeRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->typeRequests->getAll([
            'notEqual' => [
                'name' => "test",
            ],
            'greaterThan' => [
                'id' => 2,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/scans/pitfalls/types', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->typeRequests->getById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/scans/pitfalls/types/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
