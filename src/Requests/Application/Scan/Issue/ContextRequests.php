<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class ContextRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int|null $issueId
     * @param int|null $contextId
     * @return string
     */
    protected function uri($appId, $scanId, $issueId = null, $contextId = null)
    {
        if (is_null($issueId)) {
            return "/applications/{$appId}/scans/{$scanId}/issues/contexts";
        }

        return is_null($contextId)
            ? "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/contexts"
            : "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/contexts/{$contextId}";
    }

    /**
     * Get all contexts for an issue
     *
     * @param int $appId
     * @param int $scanId
     * @param int|null $issueId
     * @param array $queryParams
     * @return Response
     */
    public function getAll($appId, $scanId, $issueId = null, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get context for an issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $contextId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $scanId, $issueId, $contextId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId, $contextId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
