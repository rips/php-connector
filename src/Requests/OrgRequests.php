<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Exceptions\LibException;

class OrgRequests extends BaseRequest
{

    /**
     * Build a URI for the request
     *
     * @param int $orgId
     * @return string
     */
    protected function uri($orgId = null)
    {
        return is_null($orgId) ? '/organisations' : "/organisations/{$orgId}";
    }

    /**
     * Get all organisations
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
     * Get an organisation by id
     *
     * @param int $orgId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($orgId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($orgId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new organisation
     *
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['organisation' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing organisation
     *
     * @param int $orgId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($orgId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($orgId), [
            RequestOptions::JSON => ['organisation' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all organisations
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
     * Delete an organisation by id
     *
     * @param int $orgId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($orgId, array $queryParams = [])
    {
        if (is_null($orgId)) {
            throw new LibException('orgId is null');
        }

        $response = $this->client->delete($this->uri($orgId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
