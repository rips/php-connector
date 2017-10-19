<?php
namespace RIPS\Test\Requests\Quota;

use RIPS\Connector\Requests\Quota\AclRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class AclRequestsTest extends TestCase
{
    /** @var AclRequests */
    protected $aclRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->aclRequests = new AclRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        /** @var \stdClass $response */
        $response = $this->aclRequests->getAll(1, [
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
        $this->assertEquals('/quotas/1/acls', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->aclRequests->getById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
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
        $response = $this->aclRequests->create(1, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/quotas/1/acls', $request->getUri()->getPath());
        $this->assertEquals('acl[test]=input', $body);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->aclRequests->update(1, 2, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/quotas/1/acls/2', $request->getUri()->getPath());
        $this->assertEquals('acl[test]=input', $body);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->aclRequests->deleteAll(1, [
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
        $this->assertEquals('/quotas/1/acls', $request->getUri()->getPath());
        $this->assertEquals('notEqual[name]=test&greaterThan[id]=1', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->aclRequests->deleteById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/quotas/1/acls/2', $request->getUri()->getPath());
    }
}
