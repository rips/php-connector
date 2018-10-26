<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\Quota\AclRequests;

class QuotaRequests extends BaseRequest
{
    /**
     * @var Quota\AclRequests
     */
    protected $aclRequests;

    /**
     * Build a uri for the request
     *
     * @param int $quotaId
     * @return string
     */
    public function uri($quotaId = null)
    {
        return is_null($quotaId) ? '/quotas' : "/quotas/{$quotaId}";
    }

    /**
     * Get all quotas
     *
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a quota by id
     *
     * @param int $quotaId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($quotaId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($quotaId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new quota
     *
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['quota' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update existing quota
     *
     * @param int $quotaId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($quotaId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($quotaId), [
            RequestOptions::JSON => ['quota' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all quotas
     *
     * @param array $queryParams
     * @return void
     */
    public function deleteAll(array $queryParams = [])
    {
        $response = $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Delete quota by id
     *
     * @param int $quotaId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($quotaId, array $queryParams = [])
    {
        if (is_null($quotaId)) {
            throw new LibException('quotaId is null');
        }

        $response = $this->client->delete($this->uri($quotaId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * ACL requests accessor
     *
     * @return Quota\AclRequests
     */
    public function acls()
    {
        if (is_null($this->aclRequests)) {
            $this->aclRequests = new AclRequests($this->client);
        }

        return $this->aclRequests;
    }
}
