<?php

namespace RIPS\APIConnector\Requests;

class UserRequests extends BaseRequest
{
    // @var string
    protected $uri = '/users';

    /**
     * GET all users
     *
     * @return stdClass $response
     */
    public function getAll()
    {
        $response = $this->client->get($this->uri);

        return $this->handleResponse($response);
    }

    /**
     * GET a user by user ID
     *
     * @param int $userId
     * @return stdClass $response
     */
    public function getById(int $userId)
    {
        $response = $this->client->get("{$this->uri}/{$userId}");

        return $this->handleResponse($response);
    }

    /**
     * Invite a new user
     *
     * @param array $input
     * @return stdClass
     */
    public function invite(array $input)
    {
        $response = $this->client->post("{$this->uri}/invite/ui", [
            'form_params' => ['user' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
