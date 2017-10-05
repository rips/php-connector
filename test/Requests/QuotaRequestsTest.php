<?php

namespace RIPS\Test\Requests;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\QuotaRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Middleware;

class QuotaRequestsTest extends TestCase
{
    /** @var QuotaRequests */
    protected $quotasRequests;

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
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/quotas', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function getAllAcls()
    {
        $response = $this->quotaRequests->getAllAcls(1, [
            'greaterThan' => [
                'id' => 1,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/quotas/1/acls', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->quotaRequests->getById(1);
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/quotas/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getAclById()
    {
        $response = $this->quotaRequests->getAclById(1, 2);
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/quotas/1/acls/2', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->quotaRequests->create(['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/quotas', $request->getUri()->getPath());
        $this->assertEquals('quota[test]=input', $body);
    }

    /**
     * @test
     */
    public function createAcl()
    {
        $response = $this->quotaRequests->createAcl(1, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/quotas/1/acls', $request->getUri()->getPath());
        $this->assertEquals('acl[test]=input', $body);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->quotaRequests->update(1, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/quotas/1', $request->getUri()->getPath());
        $this->assertEquals('quota[test]=input', $body);
    }

    /**
     * @test
     */
    public function updateAcl()
    {
        $response = $this->quotaRequests->updateAcl(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/quotas/1/acls/2', $request->getUri()->getPath());
        $this->assertEquals('acl[test]=input', $body);
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
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/quotas', $request->getUri()->getPath());
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function deleteAllAcls()
    {
        $this->quotaRequests->deleteAllAcls(1, [
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
        $this->assertEquals('/quotas/1/acls', $request->getUri()->getPath());
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->quotaRequests->deleteById(1);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/quotas/1', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteAclById()
    {
        $this->quotaRequests->deleteAclById(1, 2);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/quotas/1/acls/2', $request->getUri()->getPath());
    }
}
