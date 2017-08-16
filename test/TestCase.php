<?php

namespace RIPS\Test;

use PHPUnit\Framework\TestCase as BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

abstract class TestCase extends BaseTestCase
{
    /** @var HandlerStack */
    protected $stack;

    /** @var Client */
    protected $client;

    /** @var array */
    protected $container = [];

    protected function setUp()
    {
        $this->stack = HandlerStack::create();
        $this->client = new Client(['handler' => $this->stack]);
    }
}
