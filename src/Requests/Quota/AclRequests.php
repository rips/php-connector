<?php

namespace RIPS\Connector\Requests\Quota;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class AclRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $quotaId
     * @param int $aclId
     * @return string
     */
    private function uri($quotaId, $aclId = null)
    {
        return is_null($aclId)
            ? "/quotas/{$quotaId}/acls"
            : "/quotas/{$quotaId}/acls/{$aclId}";
    }

    /**
     * Get all ACLs for a quota
     *
     * @param int $quotaId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll($quotaId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($quotaId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get ACL for quota by id
     *
     * @param int $quotaId
     * @param int $aclId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($quotaId, $aclId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($quotaId, $aclId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new ACL for a quota
     *
     * @param int $quotaId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create($quotaId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($quotaId), [
            RequestOptions::JSON => ['acl' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update existing ACL for a quota
     *
     * @param int $quotaId
     * @param int $aclId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($quotaId, $aclId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($quotaId, $aclId), [
            RequestOptions::JSON => ['acl' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all ACLs for a quota
     *
     * @param int $quotaId
     * @param array $queryParams
     * @return void
     */
    public function deleteAll($quotaId, array $queryParams = [])
    {
        $this->client->delete($this->uri($quotaId), [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete an ACL for a quota by id
     *
     * @param int $quotaId
     * @param int $aclId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($quotaId, $aclId, array $queryParams = [])
    {
        if (is_null($quotaId) || is_null($aclId)) {
            throw new LibException('quotaId or aclId is null');
        }

        $this->client->delete($this->uri($quotaId, $aclId), [
            'query' => $queryParams,
        ]);
    }
}
