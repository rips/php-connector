<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use RIPS\Connector\Exceptions\ClientException;
use RIPS\Connector\Exceptions\ServerException;

abstract class BaseRequest
{
    /** @var Client */
    protected $client;

    /**
     * Initialize new QuotaRequests
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Handle response returned by Guzzle
     *
     * @param ResponseInterface $response
     * @return \stdClass[]|\stdClass
     */
    protected function handleResponse(ResponseInterface $response)
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
