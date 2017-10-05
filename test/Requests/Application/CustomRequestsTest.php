<?php

namespace RIPS\Test\Requests\Application;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\CustomRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class CustomRequestsTest extends TestCase
{
    /** @var ScanRequests */
    protected $customRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->customRequests = new CustomRequests($this->client);
    }

    /**
     * @test
     */
    public function getAll()
    {
        $response = $this->customRequests->getAll(1, [
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
        $this->assertEquals('/applications/1/customs', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getAllIgnores()
    {
        $response = $this->customRequests->getAllIgnores(1, 2, [
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
        $this->assertEquals('/applications/1/customs/2/ignores', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getAllSanitisers()
    {
        $response = $this->customRequests->getAllSanitisers(1, 2, [
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
        $this->assertEquals('/applications/1/customs/2/sanitisers', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getAllSinks()
    {
        $response = $this->customRequests->getAllSinks(1, 2, [
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
        $this->assertEquals('/applications/1/customs/2/sinks', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getAllSources()
    {
        $response = $this->customRequests->getAllSources(1, 2, [
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
        $this->assertEquals('/applications/1/customs/2/sources', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getAllValidators()
    {
        $response = $this->customRequests->getAllValidators(1, 2, [
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
        $this->assertEquals('/applications/1/customs/2/validators', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function getById()
    {
        $response = $this->customRequests->getById(1, 2);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getIgnoreById()
    {
        $response = $this->customRequests->getIgnoreById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/ignores/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getSanitiserById()
    {
        $response = $this->customRequests->getSanitiserById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sanitisers/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getSinkById()
    {
        $response = $this->customRequests->getSinkById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getSourceById()
    {
        $response = $this->customRequests->getSourceById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sources/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getValidatorById()
    {
        $response = $this->customRequests->getValidatorById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/validators/3', $request->getUri()->getPath());
        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function create()
    {
        $this->customRequests->create(1, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/customs', $request->getUri()->getPath());
        $this->assertEquals('custom[test]=input', $body);
    }

    /**
     * @test
     */
    public function createIgnore()
    {
        $this->customRequests->createIgnore(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/ignores', $request->getUri()->getPath());
        $this->assertEquals('ignore[test]=input', $body);
    }

    /**
     * @test
     */
    public function createSanitiser()
    {
        $this->customRequests->createSanitiser(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sanitisers', $request->getUri()->getPath());
        $this->assertEquals('sanitiser[test]=input', $body);
    }

    /**
     * @test
     */
    public function createSink()
    {
        $this->customRequests->createSink(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks', $request->getUri()->getPath());
        $this->assertEquals('sink[test]=input', $body);
    }

    /**
     * @test
     */
    public function createSource()
    {
        $this->customRequests->createSource(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sources', $request->getUri()->getPath());
        $this->assertEquals('source[test]=input', $body);
    }

    /**
     * @test
     */
    public function createValidator()
    {
        $this->customRequests->createValidator(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/validators', $request->getUri()->getPath());
        $this->assertEquals('validator[test]=input', $body);
    }

    /**
     * @test
     */
    public function update()
    {
        $this->customRequests->update(1, 2, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2', $request->getUri()->getPath());
        $this->assertEquals('custom[test]=input', $body);
    }

    /**
     * @test
     */
    public function updateIgnore()
    {
        $this->customRequests->updateIgnore(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/ignores/3', $request->getUri()->getPath());
        $this->assertEquals('ignore[test]=input', $body);
    }

    /**
     * @test
     */
    public function updateSanitiser()
    {
        $this->customRequests->updateSanitiser(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sanitisers/3', $request->getUri()->getPath());
        $this->assertEquals('sanitiser[test]=input', $body);
    }

    /**
     * @test
     */
    public function updateSink()
    {
        $this->customRequests->updateSink(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks/3', $request->getUri()->getPath());
        $this->assertEquals('sink[test]=input', $body);
    }

    /**
     * @test
     */
    public function updateSource()
    {
        $this->customRequests->updateSource(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sources/3', $request->getUri()->getPath());
        $this->assertEquals('source[test]=input', $body);
    }

    /**
     * @test
     */
    public function updateValidator()
    {
        $this->customRequests->updateValidator(1, 2, 3, ['test' => 'input']);
        $request = $this->container[0]['request'];
        $body =  urldecode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/validators/3', $request->getUri()->getPath());
        $this->assertEquals('validator[test]=input', $body);
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $this->customRequests->deleteAll(1, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteAllIgnores()
    {
        $this->customRequests->deleteAllIgnores(1, 2, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/ignores', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteAllSanitisers()
    {
        $this->customRequests->deleteAllSanitisers(1, 2, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sanitisers', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteAllSinks()
    {
        $this->customRequests->deleteAllSinks(1, 2, [ 'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteAllSources()
    {
        $this->customRequests->deleteAllSources(1, 2, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sources', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteAllValidators()
    {
        $this->customRequests->deleteAllValidators(1, 2, [
            'notEqual' => [
                'phase' => 1,
            ],
            'greaterThan' => [
                'phase' => 2,
            ]
        ]);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/validators', $request->getUri()->getPath());
        $this->assertEquals('notEqual[phase]=1&greaterThan[phase]=2', $queryString);
    }

    /**
     * @test
     */
    public function deleteById()
    {
        $this->customRequests->deleteById(1, 2, 3);
        $request = $this->container[0]['request'];
        $queryString = urldecode($request->getUri()->getQuery());

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteIgnoreById()
    {
        $this->customRequests->deleteIgnoreById(1, 2, 3);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/ignores/3', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteSanitiserById()
    {
        $this->customRequests->deleteSanitiserById(1, 2, 3);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sanitisers/3', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteSinkById()
    {
        $this->customRequests->deleteSinkById(1, 2, 3);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sinks/3', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteSourceById()
    {
        $this->customRequests->deleteSourceById(1, 2, 3);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/sources/3', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function deleteValidatorById()
    {
        $this->customRequests->deleteValidatorById(1, 2, 3);
        $request = $this->container[0]['request'];

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/applications/1/customs/2/validators/3', $request->getUri()->getPath());
    }
}
