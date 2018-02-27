<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;

class TeamRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $teamId
     * @return string
     */
    public function uri($teamId = null)
    {
        return is_null($teamId) ? '/teams' : "/teams/{$teamId}";
    }

    /**
     * Get all teams
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
     * Get a team by id
     *
     * @param int $teamId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($teamId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($teamId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new team
     *
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['team' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a team by id
     *
     * @param int $teamId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($teamId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($teamId), [
            RequestOptions::JSON => ['team' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all teams
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
     * Delete a team by id
     *
     * @param int $teamId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($teamId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($teamId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
