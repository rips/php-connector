<?php

namespace RIPS\Test\Requests\Application\Scan;

use RIPS\Connector\Requests\Application\Scan\Issue\OriginRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\TypeRequests;
use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\Scan\IssueRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\CommentRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\MarkupRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\ReviewRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\SummaryRequests;
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
        /** @var \stdClass $response */
        $response = $this->issueRequests->getAll(1, 2, [
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
        /** @var \GuzzleHttp\Psr7\Request $request */
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
        /** @var \GuzzleHttp\Psr7\Request $request */
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
    public function create()
    {
        $response = $this->issueRequests->create(1, 2, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/issues', $request->getUri()->getPath());
        $this->assertEquals('{"issue":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function comments()
    {
        $commentRequests = $this->issueRequests->comments();

        $this->assertInstanceOf(CommentRequests::class, $commentRequests);
    }

    /**
     * @test
     */
    public function markups()
    {
        $markupRequests = $this->issueRequests->markups();

        $this->assertInstanceOf(MarkupRequests::class, $markupRequests);
    }

    /**
     * @test
     */
    public function origins()
    {
        $originRequests = $this->issueRequests->origins();

        $this->assertInstanceOf(OriginRequests::class, $originRequests);
    }

    /**
     * @test
     */
    public function reviews()
    {
        $reviewRequests = $this->issueRequests->reviews();

        $this->assertInstanceOf(ReviewRequests::class, $reviewRequests);
    }

    /**
     * @test
     */
    public function summaries()
    {
        $summaryRequests = $this->issueRequests->summaries();

        $this->assertInstanceOf(SummaryRequests::class, $summaryRequests);
    }

    /**
     * @test
     */
    public function types()
    {
        $typeRequests = $this->issueRequests->types();

        $this->assertInstanceOf(TypeRequests::class, $typeRequests);
    }
}
