<?php

namespace RIPS\APIConnector\Requests;

use GuzzleHttp\Client;

class UserRequests
{
    // @var string
    protected $uri = '/users';

    /**
     * Initialize new UserRequests
     *
     * @param GuzzleHttp/Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * GET all users
     *
     * @return array $response
     */
    public function getAll()
    {
        $response = $this->client->get($this->uri);

        return json_decode($response->getBody());
    }

    /**
     * GET a user by user ID
     *
     * @param int $userId
     * @return array $response
     */
    public function getById(int $userId)
    {
        $response = $this->client->get("{$this->uri}/{$userId}");

        return json_decode($response->getBody());
    }

    public function postInvite()
    {
    }
}
