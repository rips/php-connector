<?php

namespace RIPS\Test\Requests;

use RIPS\Connector\Requests\LanguageRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class LanguageRequestsTest extends TestCase
{
    /** @var LanguageRequests */
    protected $languageRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->languageRequests = new LanguageRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->languageRequests->getAll();
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/languages', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->languageRequests->getById(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/languages/1', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }
}
