<?php

namespace RIPS\Connector\Requests\Application\Scan;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class ClassRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $classId
     * @return string
     */
    protected function uri($appId, $scanId, $classId = null)
    {
        return is_null($classId)
            ? "/applications/{$appId}/scans/{$scanId}/classes"
            : "/applications/{$appId}/scans/{$scanId}/classes/{$classId}";
    }

    /**
     * Get all classes for a scan
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
     * Get a class for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $classId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $scanId, $classId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $classId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a batch of classes for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create($appId, $scanId, array $input, array $queryParams = [])
    {
        $uri = "{$this->uri($appId, $scanId)}/batches";
        $response = $this->client->post($uri, [
            RequestOptions::JSON => ['classes' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
