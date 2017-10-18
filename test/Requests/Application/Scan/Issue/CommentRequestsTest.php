<?php

namespace RIPS\Test\Requests\Application\Scan\Issue;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\Scan\Issue\CommentRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class CommentRequestsTest extends TestCase
{
    /** @var CommentRequests */
    protected $commentRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->commentRequests = new CommentRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->commentRequests->getAll(1, 2, 3, [
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
        $this->assertEquals('value', $response->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/comments', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->commentRequests->getById(1, 2, 3, 4);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/comments/4', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->commentRequests->create(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/comments', $request->getUri()->getPath());
        $this->assertEquals('comment[test]=input', $body);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $response = $this->commentRequests->deleteAll(1, 2, 3);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/comments', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $response = $this->commentRequests->deleteById(1, 2, 3, 4);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/comments/4', $request->getUri()->getPath());
    }
}
