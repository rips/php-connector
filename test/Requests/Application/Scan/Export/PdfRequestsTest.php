<?php

namespace RIPS\Test\Requests\Application\Export;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\Scan\Export\PdfRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class PdfRequestsTest extends TestCase
{
    /** @var PdfRequests */
    protected $pdfRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], 'raw value'),
        ]));

        $this->pdfRequests = new PdfRequests($this->client);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->pdfRequests->getById(1, 2, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('raw value', $response);
        $this->assertEquals('/applications/1/scans/2/exports/pdfs', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }
}
