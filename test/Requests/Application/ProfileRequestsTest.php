<?php

namespace RIPS\Test\Requests\Application;

use RIPS\Connector\Requests\Application\Profile\IgnoredCodeRequests;
use RIPS\Connector\Requests\Application\Profile\IgnoredLocationRequests;
use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\ProfileRequests;
use RIPS\Connector\Requests\Application\Profile\IgnoreRequests;
use RIPS\Connector\Requests\Application\Profile\SanitizerRequests;
use RIPS\Connector\Requests\Application\Profile\SinkRequests;
use RIPS\Connector\Requests\Application\Profile\SourceRequests;
use RIPS\Connector\Requests\Application\Profile\ValidatorRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ProfileRequestsTest extends TestCase
{
    /** @var ProfileRequests */
    protected $profileRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->profileRequests = new ProfileRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->profileRequests->getAll(1, [
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
        $this->assertEquals('/applications/1/profiles', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->profileRequests->getById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/profiles/2', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->profileRequests->create(1, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/profiles', $request->getUri()->getPath());
        $this->assertEquals('{"profile":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->profileRequests->update(1, 2, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/profiles/2', $request->getUri()->getPath());
        $this->assertEquals('{"profile":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->profileRequests->deleteAll(1, [
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
        $this->assertEquals('/applications/1/profiles', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->profileRequests->deleteById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/profiles/2', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function cloneById()
    {
        $response = $this->profileRequests->cloneById(1, 2, ['name' => 'clone', 'targetApplication' => 3]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('/applications/1/profiles/2/clone', $request->getUri()->getPath());
        $this->assertEquals('{"profile":{"name":"clone","targetApplication":3}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function ignoredCodes()
    {
        $ignoredCodeRequests = $this->profileRequests->ignoredCodes();

        $this->assertInstanceOf(IgnoredCodeRequests::class, $ignoredCodeRequests);
    }

    /**
     * @test
     */
    public function ignoredLocations()
    {
        $ignoredLocationRequests = $this->profileRequests->ignoredLocations();

        $this->assertInstanceOf(IgnoredLocationRequests::class, $ignoredLocationRequests);
    }

    /**
     * @test
     */
    public function sanitizers()
    {
        $sanitizerRequests = $this->profileRequests->sanitizers();

        $this->assertInstanceOf(SanitizerRequests::class, $sanitizerRequests);
    }

    /**
     * @test
     */
    public function sinks()
    {
        $sinkRequests = $this->profileRequests->sinks();

        $this->assertInstanceOf(SinkRequests::class, $sinkRequests);
    }

    /**
     * @test
     */
    public function sources()
    {
        $sourceRequests = $this->profileRequests->sources();

        $this->assertInstanceOf(SourceRequests::class, $sourceRequests);
    }

    /**
     * @test
     */
    public function validators()
    {
        $validatorRequests = $this->profileRequests->validators();

        $this->assertInstanceOf(ValidatorRequests::class, $validatorRequests);
    }
}
