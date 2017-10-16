<?php

namespace RIPS\Test\Requests\Application\Scan;

use RIPS\Connector\Requests\Application\Scan\ClassRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ClassRequestsTest extends TestCase
{
    /** $var ClassRequests */
    protected $classRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->classRequests = new ClassRequests($this->client);
    }
}
