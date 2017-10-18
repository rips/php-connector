<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Requests\BaseRequest;

class ConcatRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $concatId
     * @return string
     */
    protected function uri($appId, $scanId, $concatId = null)
    {
        return is_null($concatId)
            ? "/applications/{$appId}/scans/{$scanId}/concats"
            : "/applications/{$appId}/scans/{$scanId}/concats/{$concatId}";
    }

    /**
     * Get all concats for a scan
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
     * Get a concat for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $concatId
     * @return \stdClass
     */
    public function getById($appId, $scanId, $concatId)
    {
        $response = $this->client->get($this->uri($appId, $scanId, $concatId));

        return $this->handleResponse($response);
    }
}
