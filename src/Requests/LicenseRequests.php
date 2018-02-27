<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;

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
    public function getAll(array $queryParams = [])
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
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($licenseId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($licenseId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Activate a license
     *
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function activate(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['license' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
