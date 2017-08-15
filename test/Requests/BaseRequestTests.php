<?php

namespace RIPS\Test\Requests;

use RIPS\Test\TestCase;
use RIPS\Connector\Requests\BaseRequest;
use RIPS\Connector\Exceptions\ClientException;
use RIPS\Connector\Exceptions\ServerException;
use RIPS\Test\Stubs\BaseRequestStub;
use GuzzleHttp\Psr7\Response;

class BaseRequestTests extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $class = new \ReflectionClass(BaseRequestStub::class);
        $this->handleResponse = $class->getMethod('handleResponse');
        $this->baseRequest = new BaseRequestStub($this->client);

        $this->handleResponse->setAccessible(true);
    }

    /**
     * @test
     */
    public function handleResponseSuccess()
    {
        $response = new Response(200, [], '{"key": "value"}');
        $result = $this->handleResponse->invokeArgs($this->baseRequest, [$response]);

        $this->assertEquals('value', $result->key);
    }

    /**
     * @test
     * @expectedException RIPS\Connector\Exceptions\ClientException
     */
    public function handleResponseClientError()
    {
        for ($i = 400; $i <= 417; $i++) {
            $response = new Response($i, [], '{"key": "value"}');
            
            $this->handleResponse->invokeArgs($this->baseRequest, [$response]);
        }
    }

    /**
     * @test
     * @expectedException RIPS\Connector\Exceptions\ServerException
     */
    public function handleResponseServerError()
    {
        for ($i = 500; $i <= 505; $i++) {
            $response = new Response($i, [], '{"key": "value"}');
            
            $this->handleResponse->invokeArgs($this->baseRequest, [$response]);
        }
    }
}
