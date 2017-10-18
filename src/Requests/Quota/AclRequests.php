<?php

namespace RIPS\Connector\Requests\Quota;

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
     * @return \stdClass
     */
    public function getById($quotaId, $aclId)
    {
        $response = $this->client->get($this->uri($quotaId, $aclId));

        return $this->handleResponse($response);
    }

    /**
     * Create a new ACL for a quota
     *
     * @param int $quotaId
     * @param array $input
     * @return \stdClass
     */
    public function create($quotaId, array $input = [])
    {
        $response = $this->client->post($this->uri($quotaId), [
            'form_params' => ['acl' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update existing ACL for a quota
     *
     * @param int $quotaId
     * @param int $aclId
     * @param array $input
     * @return \stdClass
     */
    public function update($quotaId, $aclId, array $input = [])
    {
        $response = $this->client->patch($this->uri($quotaId, $aclId), [
            'form_params' => ['acl' => $input],
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
     * @return void
     */
    public function deleteById($quotaId, $aclId)
    {
        $this->client->delete($this->uri($quotaId, $aclId));
    }
}
