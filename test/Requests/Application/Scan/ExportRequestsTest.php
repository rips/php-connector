<?php

namespace RIPS\Test\Requests\Application\Scan;

use RIPS\Connector\Requests\Application\Scan\ExportRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class ExportRequestsTest extends TestCase
{
    /** @var ExportRequests */
    protected $exportRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->exportRequests = new ExportRequests($this->client);
    }

    /**
     * @test
     */
    public function exportCsv()
    {
        $file = __DIR__ . '\file';
        $this->exportRequests->exportCsv(1, 2, $file);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/exports/csvs', $request->getUri()->getPath());
        $this->assertTrue(file_exists($file . '.csv'));

        unlink($file . '.csv');
    }

    /**
     * @test
     */
    public function exportJiraCsv()
    {
        $file = __DIR__ . '\file';
        $this->exportRequests->exportJiraCsv(1, 2, $file);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/exports/jiracsvs', $request->getUri()->getPath());
        $this->assertTrue(file_exists($file . '.jira.csv'));

        unlink($file . '.jira.csv');
    }

    /**
     * @test
     */
    public function exportPdf()
    {
        $file = __DIR__ . '\file';
        $this->exportRequests->exportPdf(1, 2, $file);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/exports/pdfs', $request->getUri()->getPath());
        $this->assertTrue(file_exists($file . '.pdf'));

        unlink($file . '.pdf');
    }
}
