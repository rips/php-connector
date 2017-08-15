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
    // @var GuzzleHttp\HandlerStack
    protected $stack;

    // @var GuzzleHttp\Client
    protected $client;

    // @var array
    protected $container = [];

    protected function setUp()
    {
        $this->stack = HandlerStack::create();
        $this->client = new Client(['handler' => $this->stack]);
    }
}
