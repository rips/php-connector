<?php

namespace RIPS\Test\Requests;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\UserRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class UserRequestsTest extends TestCase
{
    /** @var UserRequests */
    protected $userRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->userRequests = new UserRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->userRequests->getAll([
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
        $this->assertEquals('/users', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->userRequests->getById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/users/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $this->userRequests->create(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/users', $request->getUri()->getPath());
        $this->assertEquals('{"user":{"test":"input"}}', $body);
    }

    /**
     * @test
     */
    public function update()
    {
        $this->userRequests->update(1, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/users/1', $request->getUri()->getPath());
        $this->assertEquals('{"user":{"test":"input"}}', $body);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->userRequests->deleteAll([
            'notEqual' => [
                'name' => 'test',
            ],
            'greaterThan' => [
                'id' => 1,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/users', $request->getUri()->getPath());
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->userRequests->deleteById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/users/1', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function invite()
    {
        $this->userRequests->invite(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/users/invite/ui', $request->getUri()->getPath());
        $this->assertEquals('{"user":{"test":"input"}}', $body);
    }

    /**
     * @test
     */
    public function reset()
    {
        $this->userRequests->reset(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/users/reset/ui', $request->getUri()->getPath());
        $this->assertEquals('{"reset":{"test":"input"}}', $body);
    }

    /**
     * @test
     */
    public function activate()
    {
        $this->userRequests->activate(1, 'token');
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/users/1/activate/token', $request->getUri()->getPath());
    }
    /**
     * @test
     */
    public function confirm()
    {
        $this->userRequests->confirm(1, 'token');
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/users/1/confirm/token', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function confirmReset()
    {
        $this->userRequests->confirmReset(1, 'token');
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/users/1/reset/token', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function getAllStatistics()
    {
        $response = $this->userRequests->getAllUsersStatistics();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/users/statistics', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('', $queryString);
    }

    /**
     * @test
     */
    public function getStatisticsById()
    {
        $response = $this->userRequests->getUserStatistics(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/users/1/statistics', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
