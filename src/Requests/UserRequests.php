<?php

namespace RIPS\APIConnector\Requests;

class UserRequests extends BaseRequest
{
    // @var string
    protected $uri = '/users';

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
