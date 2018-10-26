<?php

namespace RIPS\Test\Requests;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\ActivityRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ActivityRequestsTest extends TestCase
{
    /** @var ActivityRequests */
    protected $activityRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->activityRequests = new ActivityRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->activityRequests->getAll([
            'equal' => [
                'id' => 1,
            ],
            'greaterThan' => [
                'id' => 2,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/activities', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('equal[id]=1&greaterThan[id]=2', $queryString);
    }

    /**
     * @test
     */
    public function getByKey()
    {
        $response = $this->activityRequests->getById('1');
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/activities/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
