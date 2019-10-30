<?php

namespace RIPS\Test\Requests\Application\Scan\Issue;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\Scan\Issue\PatchRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class PatchRequestsTest extends TestCase
{
    /** @var PatchRequests */
    protected $patchRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->patchRequests = new PatchRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->patchRequests->getAll(1, 2, 3, [
            'notEqual' => [
                'type' => 1,
            ],
            'greaterThan' => [
                'type' => 2,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/patches', $request->getUri()->getPath());
        $this->assertEquals('notEqual[type]=1&greaterThan[type]=2', $queryString);
    }

    /**
     * @test
     */
    public function getAllWithoutIssue()
    {
        $response = $this->patchRequests->getAll(1, 2, null, [
            'notEqual' => [
                'type' => 1,
            ],
            'greaterThan' => [
                'type' => 2,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('/applications/1/scans/2/issues/patches', $request->getUri()->getPath());
        $this->assertEquals('notEqual[type]=1&greaterThan[type]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->patchRequests->getById(1, 2, 3, 4);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/patches/4', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->patchRequests->create(1, 2, 3, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/patches', $request->getUri()->getPath());
        $this->assertEquals('{"patch":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
