<?php

namespace RIPS\Test\Requests\Notification;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use RIPS\Connector\Requests\Notification\TypeRequests;
use RIPS\Test\TestCase;

class TypeRequestsTest extends TestCase
{
    /** @var TypeRequests */
    protected $typeRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->typeRequests = new TypeRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->typeRequests->getAll();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/notifications/types', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
        $this->assertEquals('', $queryString);
    }
}
