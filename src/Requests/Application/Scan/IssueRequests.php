<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Requests\BaseRequest;
use RIPS\Connector\Requests\Application\Scan\Issue\TypeRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\OriginRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\CommentRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\MarkupRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\ReviewRequests;
use RIPS\Connector\Requests\Application\Scan\Issue\SummaryRequests;

class IssueRequests extends BaseRequest
{
    /**
     * @var CommentRequests
     */
    protected $commentRequests;

    /**
     * @var MarkupRequests
     */
    protected $markupRequests;

    /**
     * @var OriginRequests
     */
    protected $originRequests;

    /**
     * @var ReviewRequests
     */
    protected $reviewRequests;

    /**
     * @var SummaryRequests
     */
    protected $summaryRequests;

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
     * @return string
     */
    protected function uri($appId, $scanId, $issueId = null)
    {
        return is_null($issueId)
            ? "/applications/{$appId}/scans/{$scanId}/issues"
            : "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}";
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
        $response = $this->client->get($this->uri($appId, $scanId, $issueId), [
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
     * Accessor for comment requests
     *
     * @return CommentRequests
     */
    public function comments()
    {
        if (is_null($this->commentRequests)) {
            $this->commentRequests = new CommentRequests($this->client);
        }

        return $this->commentRequests;
    }

    /**
     * Accessor for markup requests
     *
     * @return MarkupRequests
     */
    public function markups()
    {
        if (is_null($this->markupRequests)) {
            $this->markupRequests = new MarkupRequests($this->client);
        }

        return $this->markupRequests;
    }

    /**
     * Origin requests accessor
     *
     * @return OriginRequests
     */
    public function origins()
    {
        if (is_null($this->originRequests)) {
            $this->originRequests = new OriginRequests($this->client);
        }

        return $this->originRequests;
    }

    /**
     * Accessor for review requests
     *
     * @return ReviewRequests
     */
    public function reviews()
    {
        if (is_null($this->reviewRequests)) {
            $this->reviewRequests = new ReviewRequests($this->client);
        }

        return $this->reviewRequests;
    }

    /**
     * Accessor for summary requests
     *
     * @return SummaryRequests
     */
    public function summaries()
    {
        if (is_null($this->summaryRequests)) {
            $this->summaryRequests = new SummaryRequests($this->client);
        }

        return $this->summaryRequests;
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
