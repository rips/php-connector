<?php

namespace RIPS\Test\Requests\Application;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\CustomRequests;
use RIPS\Connector\Requests\Application\Custom\IgnoreRequests;
use RIPS\Connector\Requests\Application\Custom\SanitiserRequests;
use RIPS\Connector\Requests\Application\Custom\SinkRequests;
use RIPS\Connector\Requests\Application\Custom\SourceRequests;
use RIPS\Connector\Requests\Application\Custom\ValidatorRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class CustomRequestsTest extends TestCase
{
    /** @var CustomRequests */
    protected $customRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->customRequests = new CustomRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        /** @var \stdClass $response */
        $response = $this->customRequests->getAll(1, [
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
        $this->assertEquals('/applications/1/customs', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->customRequests->getById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->customRequests->create(1, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/customs', $request->getUri()->getPath());
        $this->assertEquals('custom[test]=input', $body);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->customRequests->update(1, 2, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2', $request->getUri()->getPath());
        $this->assertEquals('custom[test]=input', $body);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->customRequests->deleteAll(1, [
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

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->customRequests->deleteById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function ignores()
    {
        $ignoreRequests = $this->customRequests->ignores();

        $this->assertInstanceOf(IgnoreRequests::class, $ignoreRequests);
    }

    /**
     * @test
     */
    public function sanitisers()
    {
        $sanitiserRequests = $this->customRequests->sanitisers();

        $this->assertInstanceOf(SanitiserRequests::class, $sanitiserRequests);
    }

    /**
     * @test
     */
    public function sinks()
    {
        $sinkRequests = $this->customRequests->sinks();

        $this->assertInstanceOf(SinkRequests::class, $sinkRequests);
    }

    /**
     * @test
     */
    public function sources()
    {
        $sourceRequests = $this->customRequests->sources();

        $this->assertInstanceOf(SourceRequests::class, $sourceRequests);
    }

    /**
     * @test
     */
    public function validators()
    {
        $validatorRequests = $this->customRequests->validators();

        $this->assertInstanceOf(ValidatorRequests::class, $validatorRequests);
    }
}
