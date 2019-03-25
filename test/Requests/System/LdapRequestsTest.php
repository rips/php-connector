<?php
namespace RIPS\Test\Requests\System;

use RIPS\Connector\Requests\Quota\AclRequests;
use RIPS\Connector\Requests\System\LdapRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class LdapRequestsTest extends TestCase
{
    /** @var LdapRequests */
    protected $ldapRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->ldapRequests = new LdapRequests($this->client);
    }

    /**
     * @test
     */
    public function get()
    {
        $response = $this->ldapRequests->get();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/systems/ldap', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->ldapRequests->update(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals('/systems/ldap', $request->getUri()->getPath());
        $this->assertEquals('{"ldap":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function sync()
    {
        $this->ldapRequests->sync();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/systems/ldap/sync', $request->getUri()->getPath());
    }
}
