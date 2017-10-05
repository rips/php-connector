<?php

namespace RIPS\Connector\Requests;

class OrgRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $orgId
     * @return string
     */
    private function uri($orgId = null)
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
     * Get an organization by id
     *
     * @param int $orgId
     * @return \stdClass
     */
    public function getById($orgId)
    {
        $response = $this->client->get($this->uri($orgId));

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

        $this->handleResponse($response);
    }

    /**
     * Delete an organization by id
     *
     * @param int $orgId
     * @return void
     */
    public function deleteById($orgId)
    {
        $this->client->delete($this->uri($orgId));
    }

    /**
     * Update an existing organization
     *
     * @param int $orgId
     * @param array $input
     * @return \stdClass
     */
    public function update($orgId, array $input)
    {
        $response = $this->client->patch($this->uri($orgId), [
            'form_params' => ['organisation' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new organization
     *
     * @param array $input
     * @return \stdClass
     */
    public function create(array $input)
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['organisation' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
