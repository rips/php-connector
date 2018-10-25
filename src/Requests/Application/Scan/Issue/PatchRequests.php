<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Requests\Application\Scan\Issue\Patch\TypeRequests;
use RIPS\Connector\Requests\BaseRequest;

class PatchRequests extends BaseRequest
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
     * @param int $patchId
     * @return string
     */
    protected function uri($appId, $scanId, $issueId, $patchId = null)
    {
        return is_null($patchId)
            ? "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/patches"
            : "/applications/{$appId}/scans/{$scanId}/issues/{$issueId}/patches/{$patchId}";
    }

    /**
     * Get all patches for an issue
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
     * Get patch for an issue by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $issueId
     * @param int $patchId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $scanId, $issueId, $patchId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $issueId, $patchId), [
            'query' => $queryParams,
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
     * @param array $queryParams
     * @param boolean $defaultInput
     * @return \stdClass
     */
    public function create($appId, $scanId, $issueId, array $input, array $queryParams = [], $defaultInput = true)
    {
        if ($defaultInput) {
            $params = ['patch' => $input];
        } else {
            $params = $input;
        }

        $response = $this->client->post($this->uri($appId, $scanId, $issueId), [
            RequestOptions::JSON => $params,
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
