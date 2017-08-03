<?php

namespace RIPS\APIConnector\Requests;

use GuzzleHttp\Client;

abstract class BaseRequest
{
    // @var GuzzleHttp\Client
    protected $client;

    /**
     * Initialize new QuotaRequests
     *
     * @param GuzzleHttp/Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
