<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class EntrypointRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $entrypointId
     * @return string
     */
    protected function uri($appId, $scanId, $entrypointId = null)
    {
        return is_null($entrypointId)
            ? "/applications/{$appId}/scans/{$scanId}/entrypoints"
            : "/applications/{$appId}/scans/{$scanId}/entrypoints/{$entrypointId}";
    }

    /**
     * Get all entrypoints for a scan
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
     * Get an entrypoint for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $entrypointId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $scanId, $entrypointId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $entrypointId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
