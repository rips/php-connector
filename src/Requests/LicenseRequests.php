<?php

namespace RIPS\Connector\Requests;

class LicenseRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param $licenseId
     * @return string
     */
    protected function uri($licenseId = null)
    {
        return is_null($licenseId) ? '/licenses' : "/licenses/{$licenseId}";
    }

    /**
     * Get all licenses
     *
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll(array $queryParams)
    {
        $response = $this->client->get($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get license by id
     *
     * @param int $licenseId
     * @return \stdClass
     */
    public function getById($licenseId)
    {
        $response = $this->client->get($this->uri($licenseId));

        return $this->handleResponse($response);
    }

    /**
     * Activate a license
     *
     * @param array $input
     * @return \stdClass
     */
    public function activate(array $input)
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['license' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
