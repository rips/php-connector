<?php

namespace RIPS\Test\Requests\Application\Scan\Issue;

use RIPS\Connector\Requests\Application\Scan\Issue\OriginRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\Origin\TypeRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class OriginRequestsTest extends TestCase
{
    /** @var OriginRequests */
    protected $originRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->originRequests = new OriginRequests($this->client);
    }

    /**
     * @test
     */
    public function types()
    {
        $typeRequests = $this->originRequests->types();

        $this->assertInstanceOf(TypeRequests::class, $typeRequests);
    }
}
