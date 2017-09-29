<?php

namespace RIPS\Test\Requests\Application;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\Scan\IssueRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class IssueRequestsTest extends TestCase
{
    /** @var IssueRequests */
    protected $issueRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->issueRequests = new IssueRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->issueRequests->getAll(1, 2, [
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
        $this->assertEquals('/applications/1/scans/2/issues', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->issueRequests->getById(1, 2, 3, [
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
        $this->assertEquals('/applications/1/scans/2/issues/3', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getStats()
    {
        $response = $this->issueRequests->getStats(1, 2, [
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
        $this->assertEquals('/applications/1/scans/2/issues/stats', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getComments()
    {
        $response = $this->issueRequests->getComments(1, 2, 3, [
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
    public function getCommentById()
    {
        $response = $this->issueRequests->getCommentById(1, 2, 3, 4);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/comments/4', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function getMarkups()
    {
        $response = $this->issueRequests->getMarkups(1, 2, 3, [
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
        $this->assertEquals('/applications/1/scans/2/issues/3/markups', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getMarkupById()
    {
        $response = $this->issueRequests->getMarkupById(1, 2, 3, 4);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/markups/4', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function getReviews()
    {
        $response = $this->issueRequests->getReviews(1, 2, 3, [
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
        $this->assertEquals('/applications/1/scans/2/issues/3/reviews', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getReviewById()
    {
        $response = $this->issueRequests->getReviewById(1, 2, 3, 4);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/reviews/4', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function getSummaries()
    {
        $response = $this->issueRequests->getSummaries(1, 2, 3, [
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
        $this->assertEquals('/applications/1/scans/2/issues/3/summaries', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getSummaryById()
    {
        $response = $this->issueRequests->getSummaryById(1, 2, 3, 4);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('/applications/1/scans/2/issues/3/summaries/4', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->issueRequests->create(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues', $request->getUri()->getPath());
        $this->assertEquals('issue[test]=input', $body);
    }

    /**
     * @test
     */
    public function createComment()
    {
        $response = $this->issueRequests->createComment(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/comments', $request->getUri()->getPath());
        $this->assertEquals('comment[test]=input', $body);
    }

    /**
     * @test
     */
    public function createReview()
    {
        $response = $this->issueRequests->createReview(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/reviews', $request->getUri()->getPath());
        $this->assertEquals('review[test]=input', $body);
    }

    /**
     * @test
     */
    public function deleteComments()
    {
        $response = $this->issueRequests->deleteComments(1, 2, 3);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/comments', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteCommentById()
    {
        $response = $this->issueRequests->deleteCommentById(1, 2, 3, 4);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues/3/comments/4', $request->getUri()->getPath());
    }
}
