<?php

namespace RIPS\Connector\Requests\Application\Scan;

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
            : "/applications/{$scanId}/scans/{$scanId}/classes/{$classId}";
    }

    /**
     * Get all classes for a scan
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
     * Get a class for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $classId
     * @return \stdClass
     */
    public function getById($appId, $scanId, $classId)
    {
        $response = $this->client->get($this->uri($appId, $scanId, $classId));

        return $this->handleResponse($response);
    }

    /**
     * Create class for scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @return \stdClass
     */
    public function create($appId, $scanId, array $input = [])
    {
        $uri = "{$this->uri($appId, $scanId)}/batches";
        $response = $this->client->post($uri, [
            'form_params' => ['class' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
