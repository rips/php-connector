<?php

namespace RIPS\Test\Requests\Application;

use RIPS\Connector\Requests\Application\ArtifactRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ArtifactRequestsTest extends TestCase
{
    /** @var ArtifactRequests */
    protected $artifactRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->artifactRequests = new ArtifactRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->artifactRequests->getAll(1, [
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
        $this->assertEquals('/applications/1/artifacts', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->artifactRequests->getById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/artifacts/2', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->artifactRequests->deleteAll(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/artifacts', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->artifactRequests->deleteById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/artifacts/2', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->artifactRequests->create(1, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/artifacts', $request->getUri()->getPath());
        $this->assertEquals('{"artifact":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->artifactRequests->update(1, 2, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/artifacts/2', $request->getUri()->getPath());
        $this->assertEquals('{"artifact":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
