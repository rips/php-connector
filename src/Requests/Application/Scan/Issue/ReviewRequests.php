<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Requests\Application\Scan\Issue\Review\TypeRequests;
use RIPS\Connector\Requests\BaseRequest;

class ReviewRequests extends BaseRequest
{
    /**
     * @var TypeRequests
     */
    protected $typeRequests;

    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $reviewId
     * @return string
     */
    protected function uri($appId, $scanId, $issueId = null, $reviewId = null)
    {
        if (is_null($issueId)) {
            return "/applications/{$appId}/scans/{$scanId}/issues/reviews/batches";
        }

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
     * @return \stdClass[]
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
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $scanId, $issueId, $reviewId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId, $reviewId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new review for an issue
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create($appId, $scanId, $issueId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $scanId, $issueId), [
            RequestOptions::JSON => ['review' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new review for multiple issues
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function createBatch($appId, $scanId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $scanId), [
            RequestOptions::JSON => ['review' => $input],
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
