<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use RIPS\Connector\Requests\BaseRequest;

class ReviewRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $reviewId
     * @return string
     */
    protected function uri($appId, $scanId, $issueId, $reviewId = null)
    {
        return is_null($reviewId)
            ? "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/reviews"
            : "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/reviews/{$reviewId}";
    }

    /**
     * Get all reviews for an issue
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
     * Get review for an issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $reviewId
     * @return stdClass
     */
    public function getById($appId, $scanId, $issueId, $reviewId)
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId, $reviewId));

        return $this->handleResponse($response);
    }

    /**
     * Create a new review for an issue
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param array $input
     * @return\stdClass
     */
    public function create($appId, $scanId, $issueId, array $input = [])
    {
        $response = $this->client->post($this->uri($appId, $scanId, $issueId), [
            'form_params' => ['review' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
