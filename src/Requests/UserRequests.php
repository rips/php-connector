<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;

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
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($userId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($userId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new user
     *
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['user' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a user by ID
     *
     * @param int $userId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($userId, $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($userId), [
            RequestOptions::JSON => ['user' => $input],
            'query' => $queryParams,
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
     * @param array $queryParams
     * @return void
     */
    public function deleteById($userId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($userId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Invite a new user
     *
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function invite(array $input, array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri()}/invite/ui", [
            RequestOptions::JSON => ['user' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Request a reset e-mail
     *
     * @param array $input
     * @param array $queryParams
     * @return void
     */
    public function reset(array $input, array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri()}/reset/ui", [
            RequestOptions::JSON => ['reset' => $input],
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Active user account
     *
     * @param int $userId
     * @param string $token
     * @param array $queryParams
     * @return \stdClass
     */
    public function activate($userId, $token, array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri($userId)}/activate/{$token}", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Confirm email update for user account
     *
     * @param int $userId
     * @param string $token
     * @param array $queryParams
     * @return \stdClass
     */
    public function confirm($userId, $token, array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri($userId)}/confirm/{$token}", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Reset user account
     *
     * @param int $userId
     * @param string $token
     * @param array $queryParams
     * @return \stdClass
     */
    public function confirmReset($userId, $token, array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri($userId)}/reset/{$token}", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
