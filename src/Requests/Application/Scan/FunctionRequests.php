<?php

namespace RIPS\Connector\Requests\Application\Scan;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
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
     * @return Response
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
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $scanId, $functionId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $functionId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a batch of functions for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create($appId, $scanId, array $input, array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri($appId, $scanId)}/batches", [
            RequestOptions::JSON => ['functions' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
