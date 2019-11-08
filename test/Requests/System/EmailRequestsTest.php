<?php
namespace RIPS\Test\Requests\System;

use RIPS\Connector\Requests\System\EmailRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class EmailRequestsTest extends TestCase
{
    /** @var EmailRequests */
    protected $emailRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->emailRequests = new EmailRequests($this->client);
    }

    /**
     * @test
     */
    public function get()
    {
        $response = $this->emailRequests->get();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/systems/emails', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->emailRequests->update(['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals('/systems/emails', $request->getUri()->getPath());
        $this->assertEquals('{"email":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
