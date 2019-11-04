<?php

namespace RIPS\Test\Requests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use RIPS\Connector\Requests\History\ScanRequests;
use RIPS\Connector\Requests\HistoryRequests;
use RIPS\Test\TestCase;

class HistoryRequestsTest extends TestCase
{
    /** @var HistoryRequests */
    protected $historyRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->historyRequests = new HistoryRequests($this->client);
    }

    /**
     * @test
     */
    public function scans()
    {
        $scanRequests = $this->historyRequests->scans();

        $this->assertInstanceOf(ScanRequests::class, $scanRequests);
    }
}
