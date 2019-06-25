<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\Application\Scan\Pitfall\TypeRequests;
use RIPS\Connector\Requests\BaseRequest;

class PitfallRequests extends BaseRequest
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
     * @param int $pitfallId
     * @return string
     */
    protected function uri($appId, $scanId, $pitfallId = null)
    {
        return is_null($pitfallId)
            ? "/applications/{$appId}/scans/{$scanId}/pitfalls"
            : "/applications/{$appId}/scans/{$scanId}/pitfalls/{$pitfallId}";
    }

    /**
     * Get all pitfalls for a scan
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
     * Get pitfall for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $pitfallId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $scanId, $pitfallId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $pitfallId), [
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
