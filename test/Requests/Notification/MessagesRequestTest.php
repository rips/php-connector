<?php

namespace RIPS\Test\Requests\Notification;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use RIPS\Connector\Requests\Notification\MessageRequests;
use RIPS\Test\TestCase;

class MessagesRequestTest extends TestCase
{
    /** @var MessageRequests */
    protected $messageRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->messageRequests = new MessageRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->messageRequests->getAll();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/notifications/messages', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('', $queryString);
    }

    /**
     * @test
     */
    public function markAsRead()
    {
        $response = $this->messageRequests->markAsRead(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/notifications/messages/1', $request->getUri()->getPath());
        $this->assertEquals('', $body);
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
