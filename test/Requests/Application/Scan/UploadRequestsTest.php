<?php

namespace RIPS\Test\Requests\Application\Scan;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\Application\UploadRequests;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

class UploadRequestsTest extends TestCase
{
    // @var UploadRequests
    protected $uploadRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->uploadRequests = new UploadRequests($this->client);
    }

    /**
     * @test
     */
    public function upload()
    {
        $this->uploadRequests->upload(1, 'test.zip', '<?php return 123;');
        $request = $this->container[0]['request'];

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/applications/1/uploads', $request->getUri()->getPath());
    }
}
