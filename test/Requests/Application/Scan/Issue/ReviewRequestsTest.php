<?php

namespace RIPS\Test\Requests\Application\Scan\Issue;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\Scan\Issue\ReviewRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ReviewRequestsTest extends TestCase
{
    /** @var ReviewRequests */
    protected $reviewRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->reviewRequests = new ReviewRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        /** @var \stdClass $response */
        $response = $this->reviewRequests->getAll(1, 2, 3, [
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
        $this->assertEquals('value', $response->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/reviews', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->reviewRequests->getById(1, 2, 3, 4);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/reviews/4', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->reviewRequests->create(1, 2, 3, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/reviews', $request->getUri()->getPath());
        $this->assertEquals('{"review":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->key);
    }
}
