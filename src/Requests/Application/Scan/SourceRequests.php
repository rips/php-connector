<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Requests\Application\Scan\Source\TypeRequests;
use RIPS\Connector\Requests\BaseRequest;

class SourceRequests extends BaseRequest
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
     * @param int $sourceId
     * @return string
     */
    protected function uri($appId, $scanId, $sourceId = null)
    {
        return is_null($sourceId)
            ? "/applications/{$appId}/scans/{$scanId}/sources"
            : "/applications/{$appId}/scans/{$scanId}/sources/{$sourceId}";
    }

    /**
     * Get all sources for a scan
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
     * Get source for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $sourceId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $scanId, $sourceId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $sourceId), [
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
