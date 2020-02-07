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
        $this->assertTrue(file_exists($file));

        unlink($file);
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
        $this->assertTrue(file_exists($file));

        unlink($file);
    }

    /**
     * @test
     */
    public function queuePdf()
    {
        $response = $this->exportRequests->queuePdf(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/exports/pdfs/queues', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function getQueuedPdf()
    {
        $response = $this->exportRequests->getQueuedPdf(1, 2, 3);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/exports/pdfs/queues/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function getAllQueuedPdf()
    {
        $response = $this->exportRequests->getAllQueuedPdf(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/exports/pdfs/queues', $request->getUri()->getPath());
        $this->assertEquals('value', $response->getDecodedData()->key);
    }

    /**
     * @test
     */
    public function deleteQueuedPdf()
    {
        $response = $this->exportRequests->deleteQueuedPdf(1, 2, 3);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/exports/pdfs/queues/3', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function downloadQueuedPdf()
    {
        $file = __DIR__ . '\file';
        $this->exportRequests->downloadQueuedPdf(1, 2, 3, $file);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/exports/pdfs/queues/3/downloads', $request->getUri()->getPath());
        $this->assertTrue(file_exists($file));

        unlink($file);
    }
}
