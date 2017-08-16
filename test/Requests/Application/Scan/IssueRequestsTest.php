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
}
