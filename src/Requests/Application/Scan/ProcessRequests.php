<?php

namespace RIPS\Connector\Requests\Application\Scan;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class ProcessRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $processId
     * @return string
     */
    protected function uri($appId, $scanId, $processId = null)
    {
        return is_null($processId)
            ? "/applications/{$appId}/scans/{$scanId}/processes"
            : "/applications/{$appId}/scans/{$scanId}/processes/{$processId}";
    }

    /**
     * Get all processes for a scan
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
     * Kill all processes from a scan
     *
     * @param $appId
     * @param $scanId
     * @return Response
     */
    public function deleteAll($appId, $scanId)
    {
        $response = $this->client->delete($this->uri($appId, $scanId));

        return $this->handleResponse($response);
    }

    /**
     * Get process for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $processId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $scanId, $processId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $processId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a process for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create($appId, $scanId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $scanId), [
            RequestOptions::JSON => ['process' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a process for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $processId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $scanId, $processId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $scanId, $processId), [
            RequestOptions::JSON => ['process' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
