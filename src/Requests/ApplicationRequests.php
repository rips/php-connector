<?php

namespace RIPS\Connector\Requests;

class ApplicationRequests extends BaseRequest
{
    /** @var string */
    protected $uri = '/applications';

    /**
     * Get all applications
     *
     * @param array $queryParams
     * @return \stdClass
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get application by id
     *
     * @param int $applicationId
     * @return \stdClass
     */
    public function getById($applicationId)
    {
        $response = $this->client->get("{$this->uri}/{$applicationId}");

        return $this->handleResponse($response);
    }

    /**
     * Create a new application
     *
     * @param array $input
     * @return \stdClass
     */
    public function create(array $input = [])
    {
        $response = $this->client->post("{$this->uri}", [
            'form_params' => ['application' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing application
     *
     * @param int $applicationId
     * @param array $input
     * @return \stdClass
     */
    public function update($applicationId, array $input = [])
    {
        $response = $this->client->patch("{$this->uri}/{$applicationId}", [
            'form_params' => ['application' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all applications for current user
     *
     * @param array $queryParams
     * @return void
     */
    public function deleteAll(array $queryParams = [])
    {
        $this->client->delete($this->uri, [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete application by id
     *
     * @param int $applicationId
     * @return void
     */
    public function deleteById($applicationId)
    {
        $this->client->delete("{$this->uri}/{$applicationId}");
    }
}
