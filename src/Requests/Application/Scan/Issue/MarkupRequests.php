<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use RIPS\Connector\Requests\BaseRequest;

class MarkupRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $markupId
     * @return string
     */
    protected function uri($appId, $scanId, $issueId, $markupId = null)
    {
        return is_null($markupId)
            ? "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/markups"
            : "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/markups/{$markupId}";
    }

    /**
     * Get all markups for an issue
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAll($appId, $scanId, $issueId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get markup for an issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $markupId
     * @return stdClass
     */
    public function getById($appId, $scanId, $issueId, $markupId)
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId, $markupId));

        return $this->handleResponse($response);
    }
}
