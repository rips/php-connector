<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use RIPS\Connector\Requests\BaseRequest;

class SummaryRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $summaryId
     * @return string
     */
    protected function uri($appId, $scanId, $issueId, $summaryId = null)
    {
        return is_null($summaryId)
            ? "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/summaries"
            : "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/summaries/{$summaryId}";
    }

    /**
     * Get all summaries for an issue
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
     * Get summary for an issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $summaryId
     * @return stdClass
     */
    public function getById($appId, $scanId, $issueId, $summaryId)
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId, $summaryId));

        return $this->handleResponse($response);
    }
}
