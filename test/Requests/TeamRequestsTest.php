<?php

namespace RIPS\Test\Requests;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\TeamRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Middleware;

class TeamRequestsTest extends TestCase
{
    /** @var TeamRequests */
    protected $teamRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->teamRequests = new TeamRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->teamRequests->getAll([
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
        $this->assertEquals('/teams', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->teamRequests->getById(1);
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/teams/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->teamRequests->create(['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/teams', $request->getUri()->getPath());
        $this->assertEquals('team[test]=input', $body);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->teamRequests->update(1, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/teams/1', $request->getUri()->getPath());
        $this->assertEquals('team[test]=input', $body);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->teamRequests->deleteAll([
            'notEqual' => [
                'name' => 'test',
            ],
            'greaterThan' => [
                'id' => 1,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/teams', $request->getUri()->getPath());
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->teamRequests->deleteById(1);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/teams/1', $request->getUri()->getPath());
    }
}
