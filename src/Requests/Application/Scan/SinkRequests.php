<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Requests\BaseRequest;

class SinkRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $sinkId
     * @return string
     */
    protected function uri($appId, $scanId, $sinkId = null)
    {
        return is_null($sinkId)
            ? "/applications/{$appId}/scans/{$scanId}/sinks"
            : "/applications/{$appId}/scans/{$scanId}/sinks/{$sinkId}";
    }

    /**
     * Get all sinks for a scan
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
     * Get sink for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $sinkId
     * @return \stdClass
     */
    public function getById($appId, $scanId, $sinkId)
    {
        $response = $this->client->get($this->uri($appId, $scanId, $sinkId));

        return $this->handleResponse($response);
    }
}
