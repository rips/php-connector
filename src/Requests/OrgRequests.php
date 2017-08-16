<?php

namespace RIPS\Connector\Requests;

class OrgRequests extends BaseRequest
{
    /** @var string */
    protected $uri = '/organisations';

    /**
     * Get an organization by id
     *
     * @param int $orgId
     * @return \stdClass
     */
    public function getById(int $orgId)
    {
        $response = $this->client->get("{$this->uri}/$orgId");

        return $this->handleResponse($response);
    }

    /**
     * Update an existing organization
     *
     * @param int $orgId
     * @param array $input
     * @return \stdClass
     */
    public function update(int $orgId, array $input)
    {
        $response = $this->client->patch("{$this->uri}/$orgId", [
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
        $response = $this->client->post($this->uri, [
            'form_params' => ['organisation' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
