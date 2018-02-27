<?php

namespace RIPS\Test\Requests;

use RIPS\Connector\Requests\Application\AclRequests;
use RIPS\Connector\Requests\Application\CustomRequests;
use RIPS\Connector\Requests\Application\ScanRequests;
use RIPS\Connector\Requests\Application\UploadRequests;
use RIPS\Connector\Requests\ApplicationRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ApplicationRequestsTest extends TestCase
{
    /** @var ApplicationRequests */
    protected $applicationRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->applicationRequests = new ApplicationRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        /** @var \stdClass $response */
        $response = $this->applicationRequests->getAll([
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
        $this->assertEquals('/applications', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->applicationRequests->getById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->applicationRequests->update(1, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1', $request->getUri()->getPath());
        $this->assertEquals('{"application":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->applicationRequests->deleteAll([
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
        $this->assertEquals('/applications', $request->getUri()->getPath());
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->applicationRequests->deleteById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function acls()
    {
        $aclRequests = $this->applicationRequests->acls();

        $this->assertInstanceOf(AclRequests::class, $aclRequests);
    }

    /**
     * @test
     */
    public function customs()
    {
        $customRequests = $this->applicationRequests->customs();

        $this->assertInstanceOf(CustomRequests::class, $customRequests);
    }

    /**
     * @test
     */
    public function scans()
    {
        $scanRequests = $this->applicationRequests->scans();

        $this->assertInstanceOf(ScanRequests::class, $scanRequests);
    }

    /**
     * @test
     */
    public function uploads()
    {
        $uploadRequests = $this->applicationRequests->uploads();

        $this->assertInstanceOf(UploadRequests::class, $uploadRequests);
    }
}
