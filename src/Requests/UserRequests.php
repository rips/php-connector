<?php

namespace RIPS\Connector\Requests;

class UserRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $userId
     * @return string
     */
    public function uri($userId = null)
    {
        return is_null($userId) ? '/users' : "/users/{$userId}";
    }

    /**
     * Get all users
     *
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri(), [
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
        $response = $this->client->get($this->uri($userId));

        return $this->handleResponse($response);
    }

    /**
     * Create a new user
     *
     * @param array $input
     * @return \stdClass
     */
    public function create(array $input)
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['user' => $input],
        ]);

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
        $response = $this->client->patch($this->uri($userId), [
            'form_params' => ['user' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all users
     *
     * @param array $queryParams
     * @return void
     */
    public function deleteAll(array $queryParams = [])
    {
        $response = $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Delete a user by id
     *
     * @param int $userId
     * @return void
     */
    public function deleteById($userId)
    {
        $response = $this->client->delete($this->uri($userId));

        $this->handleResponse($response, true);
    }

    /**
     * Invite a new user
     *
     * @param array $input
     * @return \stdClass
     */
    public function invite(array $input)
    {
        $response = $this->client->post("{$this->uri()}/invite/ui", [
            'form_params' => ['user' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Request a reset e-mail
     *
     * @param array $input
     * @return void
     */
    public function reset(array $input)
    {
        $response = $this->client->post("{$this->uri()}/reset/ui", [
            'form_params' => ['reset' => $input],
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Active user account
     *
     * @param int $userId
     * @param string $token
     * @return \stdClass
     */
    public function activate($userId, $token)
    {
        $response = $this->client->post("{$this->uri($userId)}/activate/{$token}");

        return $this->handleResponse($response);
    }

    /**
     * Confirm email update for user account
     *
     * @param int $userId
     * @param string $token
     * @return \stdClass
     */
    public function confirm($userId, $token)
    {
        $response = $this->client->post("{$this->uri($userId)}/confirm/{$token}");

        return $this->handleResponse($response);
    }

    /**
     * Reset user account
     *
     * @param int $userId
     * @param string $token
     * @return \stdClass
     */
    public function confirmReset($userId, $token)
    {
        $response = $this->client->post("{$this->uri($userId)}/reset/{$token}");

        return $this->handleResponse($response);
    }
}
