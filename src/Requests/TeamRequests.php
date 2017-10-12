<?php

namespace RIPS\Connector\Requests;

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
     * @return \stdClass
     */
    public function getById($teamId)
    {
        $response = $this->client->get($this->uri($teamId));

        return $this->handleResponse($response);
    }

    /**
     * Create a new team
     *
     * @param array $input
     * @return \stdClass
     */
    public function create(array $input)
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['team' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a team by id
     *
     * @param int $teamId
     * @param array $input
     * @return \stdClass
     */
    public function update($teamId, array $input)
    {
        $response = $this->client->patch($this->uri($teamId), [
            'form_params' => ['team' => $input],
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
        $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete a team by id
     *
     * @param int $teamId
     * @return void
     */
    public function deleteById($teamId)
    {
        $this->client->delete($this->uri($teamId));
    }
}
