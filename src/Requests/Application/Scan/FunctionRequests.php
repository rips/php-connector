<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Requests\BaseRequest;

class FunctionRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $functionId
     * @return string
     */
    protected function uri($appId, $scanId, $functionId = null)
    {
        return is_null($functionId)
            ? "/applications/{$appId}/scans/{$scanId}/functions"
            : "/applications/{$appId}/scans/{$scanId}/functions/{$functionId}";
    }

    /**
     * Get all functions for a scan
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
     * Get function for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $functionId
     * @return \stdClass
     */
    public function getById($appId, $scanId, $functionId)
    {
        $response = $this->client->get($this->uri($appId, $scanId, $functionId));

        return $this->handleResponse($response);
    }

    /**
     * Create a function for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @return \stdClass
     */
    public function create($appId, $scanId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId, $scanId)}/batches", [
            'form_params' => ['function' => $input],
        ]);

        return $this->handleResponse($response);
    }
}