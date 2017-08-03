<?php

namespace RIPS\APIConnector\Requests;

use GuzzleHttp\Client;

class QuotaRequests
{
    // @var string
    protected $uri = '/quotas';

    /**
     * Initialize new QuotaRequests
     *
     * @param GuzzleHttp/Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $input)
    {
        $response = $this->client->post($this->uri, [
            'form_params' => ['quota' => $input],
        ]);

        return json_decode($response->getBody());
    }
}
