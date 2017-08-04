<?php

namespace RIPS\APIConnector\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use RIPS\APIConnector\Exceptions\ClientException;
use RIPS\APIConnector\Exceptions\ServerException;

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

    protected function handleResponse(Response $response)
    {
        $statusCode = (int) floor($response->getStatusCode() / 100);

        if ($statusCode === 4) {
            throw new ClientException($response->getBody(), $response->getStatusCode());
        } elseif ($statusCode === 5) {
            throw new ServerException($response->getBody(), $response->getStatusCode());
        }

        return json_decode($response->getBody());
    }
}
