<?php

namespace RIPS\Connector\Requests;

class QuotaRequests extends BaseRequest
{
    /** @var string */
    protected $uri = '/quotas';

    /**
     * Get all quotas
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
     * Get a quota by id
     *
     * @param int $quotaId
     * @return \stdClass
     */
    public function getById($quotaId)
    {
        $response = $this->client->get("{$this->uri}/$quotaId");

        return $this->handleResponse($response);
    }

    /**
     * Create a new quota
     *
     * @param array $input
     * @return \stdClass
     */
    public function create(array $input)
    {
        $response = $this->client->post($this->uri, [
            'form_params' => ['quota' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
