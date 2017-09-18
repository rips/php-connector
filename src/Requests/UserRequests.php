<?php

namespace RIPS\Connector\Requests;

class UserRequests extends BaseRequest
{
    /** @var string */
    protected $uri = '/users';

    /**
     * Get all users
     *
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a user by user ID
     *
     * @param int $userId
     * @return \stdClass
     */
    public function getById($userId)
    {
        $response = $this->client->get("{$this->uri}/{$userId}");

        return $this->handleResponse($response);
    }

    /**
     * Update a user by ID
     *
     * @param int $userId
     * @param array $input
     * @return \stdClass
     */
    public function update($userId, $input)
    {
        $response = $this->client->patch("{$this->uri}/{$userId}", [
            'form_params' => ['user' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Invite a new user
     *
     * @param array $input
     * @return \stdClass
     */
    public function invite(array $input)
    {
        $response = $this->client->post("{$this->uri}/invite/ui", [
            'form_params' => ['user' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
