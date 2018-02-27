<?php

namespace RIPS\Test\Requests\Application;

use RIPS\Connector\Requests\Application\Scan\ClassRequests;
use RIPS\Connector\Requests\Application\Scan\ComparisonRequests;
use RIPS\Connector\Requests\Application\Scan\ConcatRequests;
use RIPS\Connector\Requests\Application\Scan\ExportRequests;
use RIPS\Connector\Requests\Application\Scan\FileRequests;
use RIPS\Connector\Requests\Application\Scan\FunctionRequests;
use RIPS\Connector\Requests\Application\Scan\IssueRequests;
use RIPS\Connector\Requests\Application\Scan\ProcessRequests;
use RIPS\Connector\Requests\Application\Scan\SinkRequests;
use RIPS\Connector\Requests\Application\Scan\SourceRequests;
use RIPS\Connector\Requests\Application\ScanRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;
use Symfony\Component\Stopwatch\Stopwatch;

class ScanRequestsTest extends TestCase
{
    /** @var ScanRequests */
    protected $scanRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->scanRequests = new ScanRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        /** @var \stdClass $response */
        $response = $this->scanRequests->getAll(null, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/scans/all', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getAllWithAppId()
    {
        /** @var \stdClass $response */
        $response = $this->scanRequests->getAll(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->scanRequests->getById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getStats()
    {
        $response = $this->scanRequests->getStats(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/stats', $request->getUri()->getPath());
        $this->assertEquals('equal[id]=2', $queryString);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $response = $this->scanRequests->create(1, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans', $request->getUri()->getPath());
        $this->assertEquals('{"scan":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function update()
    {
        $response = $this->scanRequests->update(1, 2, ['test' => 'input']);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];
        $body = urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2', $request->getUri()->getPath());
        $this->assertEquals('{"scan":{"test":"input"}}', $body);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->scanRequests->deleteAll(1);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->scanRequests->deleteById(1, 2);
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function blockUntilDone()
    {
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"phase": 1, "percent": 25}'),
            new Response(200, ['x-header' => 'header-content'], '{"phase": 0, "percent": 100}'),
        ]));

        $stopwatch = new Stopwatch();
        $stopwatch->start('blockUntilDone');
        $this->scanRequests->blockUntilDone(1, 1, 0, 2);
        $duration = floor($stopwatch->stop('blockUntilDone')->getDuration() / 1000);

        /** @var \GuzzleHttp\Psr7\Request $request1 */
        $request1 = $this->container[0]['request'];
        /** @var \GuzzleHttp\Psr7\Request $request2 */
        $request2 = $this->container[1]['request'];

        $this->assertEquals(2, $duration);
        $this->assertEquals(2, count($this->container));
        $this->assertEquals('/applications/1/scans/1', $request1->getUri()->getPath());
        $this->assertEquals('/applications/1/scans/1', $request2->getUri()->getPath());
    }

    /**
     * @test
     */
    public function classes()
    {
        $classRequests = $this->scanRequests->classes();

        $this->assertInstanceOf(ClassRequests::class, $classRequests);
    }

    /**
     * @test
     */
    public function comparisons()
    {
        $comparisonRequests = $this->scanRequests->comparisons();

        $this->assertInstanceOf(ComparisonRequests::class, $comparisonRequests);
    }

    /**
     * @test
     */
    public function concats()
    {
        $concatRequests = $this->scanRequests->concats();

        $this->assertInstanceOf(ConcatRequests::class, $concatRequests);
    }

    /**
     * @test
     */
    public function exports()
    {
        $exportRequests = $this->scanRequests->exports();

        $this->assertInstanceOf(ExportRequests::class, $exportRequests);
    }

    /**
     * @test
     */
    public function files()
    {
        $fileRequests = $this->scanRequests->files();

        $this->assertInstanceOf(FileRequests::class, $fileRequests);
    }

    /**
     * @test
     */
    public function functions()
    {
        $functionRequests = $this->scanRequests->functions();

        $this->assertInstanceOf(FunctionRequests::class, $functionRequests);
    }

    /**
     * @test
     */
    public function issues()
    {
        $issueRequests = $this->scanRequests->issues();

        $this->assertInstanceOf(IssueRequests::class, $issueRequests);
    }

    /**
     * @test
     */
    public function processes()
    {
        $processRequests = $this->scanRequests->processes();

        $this->assertInstanceOf(ProcessRequests::class, $processRequests);
    }

    /**
     * @test
     */
    public function sinks()
    {
        $sinkRequests = $this->scanRequests->sinks();

        $this->assertInstanceOf(SinkRequests::class, $sinkRequests);
    }

    /**
     * @test
     */
    public function sources()
    {
        $sourceRequests = $this->scanRequests->sources();

        $this->assertInstanceOf(SourceRequests::class, $sourceRequests);
    }
}
