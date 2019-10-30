<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class SummaryRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int|null $issueId
     * @param int|null $summaryId
     * @return string
     */
    protected function uri($appId, $scanId, $issueId = null, $summaryId = null)
    {
        if (is_null($issueId)) {
            return "/applications/{$appId}/scans/{$scanId}/issues/summaries";
        }

        return is_null($summaryId)
            ? "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/summaries"
            : "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/summaries/{$summaryId}";
    }

    /**
     * Get all summaries for an issue
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
     * Get summary for an issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $summaryId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $scanId, $issueId, $summaryId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId, $summaryId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
