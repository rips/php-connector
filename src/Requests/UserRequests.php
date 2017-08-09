<?php

namespace RIPS\Connector\Requests;

class UserRequests extends BaseRequest
{
    // @var string
    protected $uri = '/users';

    /**
     * Get all users
     *
     * @return array
     */
    public function getAll()
    {
        $response = $this->client->get($this->uri);

        return $this->handleResponse($response);
    }

    /**
     * Get a user by user ID
     *
     * @param int $userId
     * @return array
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
     * @return array
     */
    public function invite(array $input)
    {
        $response = $this->client->post("{$this->uri}/invite/ui", [
            'form_params' => ['user' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
