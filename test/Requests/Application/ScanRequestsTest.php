<?php

namespace RIPS\Test\Requests\Application;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\ScanRequests;
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
        $response = $this->scanRequests->getAll(null, [
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
        $this->assertEquals('/applications/scans/all', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getAllById()
    {
        $response = $this->scanRequests->getAll(1);
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
    public function getAllClasses()
    {
        $response = $this->scanRequests->getAllClasses(1, 2, [
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
        $this->assertEquals('/applications/1/scans/2/classes', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getClassById()
    {
        $response = $this->scanRequests->getClassById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/classes/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getComparison()
    {
        $response = $this->scanRequests->getComparison(1, 2);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/comparison', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getAllConcats()
    {
        $response = $this->scanRequests->getAllConcats(1, 2, [
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
        $this->assertEquals('/applications/1/scans/2/concats', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getConcatById()
    {
        $response = $this->scanRequests->getConcatById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/concats/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getAllFiles()
    {
        $response = $this->scanRequests->getAllFiles(1, 2, [
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
        $this->assertEquals('/applications/1/scans/2/files', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getFileById()
    {
        $response = $this->scanRequests->getFileById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/files/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getAllFunctions()
    {
        $response = $this->scanRequests->getAllFunctions(1, 2, [
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
        $this->assertEquals('/applications/1/scans/2/functions', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getFunctionById()
    {
        $response = $this->scanRequests->getFunctionById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/functions/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->scanRequests->deleteAll(1);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteFiles()
    {
        $this->scanRequests->deleteFiles(1, 2);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/files', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->scanRequests->deleteById(1, 2);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function update()
    {
        $this->scanRequests->update(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2', $request->getUri()->getPath());
        $this->assertEquals('scan[test]=input', $body);
    }

    /**
     * @test
     */
    public function create()
    {
        $this->scanRequests->create(1, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans', $request->getUri()->getPath());
        $this->assertEquals('scan[test]=input', $body);
    }

    /**
     * @test
     */
    public function createClass()
    {
        $this->scanRequests->createClass(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/classes/batches', $request->getUri()->getPath());
        $this->assertEquals('class[test]=input', $body);
    }

    /**
     * @test
     */
    public function createFunction()
    {
        $this->scanRequests->createFunction(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/scans/2/functions/batches', $request->getUri()->getPath());
        $this->assertEquals('function[test]=input', $body);
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
        $response = $this->scanRequests->blockUntilDone(1, 1, 0, 2);
        $duration = floor($stopwatch->stop('blockUntilDone')->getDuration() / 1000);

        $this->assertEquals(2, $duration);
        $this->assertEquals(2, count($this->container));
        $this->assertEquals('/applications/1/scans/1', $this->container[0]['request']->getUri()->getPath());
        $this->assertEquals('/applications/1/scans/1', $this->container[1]['request']->getUri()->getPath());
    }
}
