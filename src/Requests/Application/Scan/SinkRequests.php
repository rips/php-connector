<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\Application\Scan\Sink\TypeRequests;
use RIPS\Connector\Requests\BaseRequest;

class SinkRequests extends BaseRequest
{
    /**
     * @var TypeRequests
     */
    protected $typeRequests;

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
     * Get sink for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $sinkId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $scanId, $sinkId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $sinkId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Type requests accessor
     *
     * @return TypeRequests
     */
    public function types()
    {
        if (is_null($this->typeRequests)) {
            $this->typeRequests = new TypeRequests($this->client);
        }

        return $this->typeRequests;
    }
}
