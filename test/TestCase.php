<?php

namespace RIPS\Test;

use PHPUnit\Framework\TestCase as BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

abstract class TestCase extends BaseTestCase
{
    protected $handler;
    protected $client;

    protected function setUp()
    {
        $mock = new MockHandler();
        $this->handler = HandlerStack::create($mock);
        $this->client = new Client([
            'handler' => $this->handler,
        ]);
    }
}
