<?php

namespace RIPS\Test\Requests;

use RIPS\Connector\Requests\Quota\AclRequests;
use RIPS\Test\TestCase;
use RIPS\Connector\Requests\QuotaRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class QuotaRequestsTest extends TestCase
{
    /** @var QuotaRequests */
    protected $quotaRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->quotaRequests = new QuotaRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->quotaRequests->getAll([
            'greaterThan' => [
                'id' => 1,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/quotas', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->quotaRequests->getById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/quotas/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->quotaRequests->create(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/quotas', $request->getUri()->getPath());
        $this->assertEquals('{"quota":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->quotaRequests->update(1, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/quotas/1', $request->getUri()->getPath());
        $this->assertEquals('{"quota":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->quotaRequests->deleteAll([
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
        $this->assertEquals('/quotas', $request->getUri()->getPath());
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->quotaRequests->deleteById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/quotas/1', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function acls()
    {
        $aclRequests = $this->quotaRequests->acls();

        $this->assertInstanceOf(AclRequests::class, $aclRequests);
    }
}
