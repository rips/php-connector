<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Requests\BaseRequest;

class IssueRequests extends BaseRequest
{
    /** @var string */
    protected $uri = '/applications';

    protected function uri($appId, $scanId)
    {
        return "/applications/{$appId}/scans/{$scanId}/issues";
    }

    /**
     * Get all issues within a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getAll($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $scanId, $issueId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get stats for all issues of scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getStats($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/stats", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get comments for an issue
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getComments($appId, $scanId, $issueId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}/comments", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get comment for issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $commentId
     * @return \stdClass
     */
    public function getCommentById($appId, $scanId, $issueId, $commentId)
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}/comments/{$commentId}");

        return $this->handleResponse($response);
    }

    /**
     * Get all markups for an issue
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getMarkups($appId, $scanId, $issueId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}/markups", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get markup for issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $markupId
     * @return \stdClass
     */
    public function getMarkupById($appId, $scanId, $issueId, $markupId)
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}/markups/{$markupId}");

        return $this->handleResponse($response);
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
    public function getReviews($appId, $scanId, $issueId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}/reviews", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a review for an issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $reviewId
     * @return \stdClass
     */
    public function getReviewById($appId, $scanId, $issueId, $reviewId)
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}/reviews/{$reviewId}");

        return $this->handleResponse($response);
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
    public function getSummaries($appId, $scanId, $issueId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}/summaries", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get summary for issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $reviewId
     * @return stdClass
     */
    public function getSummaryById($appId, $scanId, $issueId, $summaryId)
    {
        $response = $this->client->get("{$this->uri($appId, $scanId)}/{$issueId}/summaries/{$summaryId}");

        return $this->handleResponse($response);
    }

    /**
     * Create a new issue for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @return \stdClass
     */
    public function create($appId, $scanId, array $input = [])
    {
        $response = $this->client->post($this->uri($appId, $scanId), [
            'form_params' => ['issue' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new comment for an issue
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param array $input
     * @return \stdClass
     */
    public function createComment($appId, $scanId, $issueId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId, $scanId)}/{$issueId}/comments", [
            'form_params' => ['comment' => $input],
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
     * @return \stdClass
     */
    public function createReview($appId, $scanId, $issueId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId, $scanId)}/{$issueId}/reviews", [
            'form_params' => ['review' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all comments for an issue
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueid
     * @return void
     */
    public function deleteComments($appId, $scanId, $issueId)
    {
        $this->client->delete("{$this->uri($appId, $scanId)}/{$issueId}/comments");
    }

    /**
     * Delete comment of issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $commentId
     * @return void
     */
    public function deleteCommentById($appId, $scanId, $issueId, $commentId)
    {
        $this->client->delete("{$this->uri($appId, $scanId)}/{$issueId}/comments/{$commentId}");
    }
}
