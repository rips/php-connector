<?php

namespace RIPS\Connector\Requests\Application\Scan;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Requests\BaseRequest;

class FrameworkRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $frameworkId
     * @return string
     */
    protected function uri($appId, $scanId, $frameworkId = null)
    {
        return is_null($frameworkId)
            ? "/applications/{$appId}/scans/{$scanId}/frameworks"
            : "/applications/{$appId}/scans/{$scanId}/frameworks/{$frameworkId}";
    }

    /**
     * Get all frameworks for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get framework for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $frameworkId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $scanId, $frameworkId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $frameworkId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a framework for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create($appId, $scanId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $scanId), [
            RequestOptions::JSON => ['framework' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
    /**
     * Update a framework for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $frameworkId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($appId, $scanId, $frameworkId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $scanId, $frameworkId), [
            RequestOptions::JSON => ['framework' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all frameworks
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return void
     */
    public function deleteAll($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $scanId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Delete a framework by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $frameworkId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, $scanId, $frameworkId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $scanId, $frameworkId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
