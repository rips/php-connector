<?php

namespace RIPS\Test;

use RIPS\APIConnector\Requests\UserRequests;
use RIPS\Test\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;

class UserRequestsTests extends TestCase
{
    // @var UserRequest
    protected $userRequests;

    protected function setUp()
    {
        parent::setUp();

        $mock = new MockHandler([
            new Response(200, ['headers' => 'something'], '{"key": "value"}'),
        ]);

        $this->handler->setHandler($mock);

        $this->userRequests = new UserRequests($this->client);
    }

    /**
     * @test
     */
    public function getAllSuccessReturnsResponseBody()
    {
        $response = $this->userRequests->getAll();

        $this->assertEquals('value', $response->key);
    }

    /**
     * @test
     */
    public function getByIdSuccessReturnsResponseBody()
    {
        $response = $this->userRequests->getbyid(1);

        $this->assertEquals('value', $response->key);
    }
}
