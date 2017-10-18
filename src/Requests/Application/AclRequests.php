<?php

namespace RIPS\Connector\Requests\Application;

use RIPS\Connector\Requests\BaseRequest;

class AclRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int $aclId
     * @return string
     */
    private function uri($appId, $aclId = null)
    {
        return is_null($aclId)
            ? "/applications/{$appId}/acls"
            : "/applications/{$appId}/acls/{$aclId}";
    }

    /**
     * Get all ACLs for an application
     *
     * @param int $appId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll($appId = null, array $queryParams = [])
    {
        $uri = is_null($appId) ? '/applications/acls/own' : $this->uri($appId);

        $response = $this->client->get($uri, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get ACL for application by id
     *
     * @param int $appId
     * @param int $aclId
     * @return \stdClass
     */
    public function getById($appId, $aclId)
    {
        $response = $this->client->get($this->uri($appId, $aclId));

        return $this->handleResponse($response);
    }

    /**
     * Create a new ACL for an application
     *
     * @param int $appId
     * @param array $input
     * @return \stdClass
     */
    public function create($appId, array $input = [])
    {
        $response = $this->client->post($this->uri($appId), [
            'form_params' => ['acl' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update ACL for app by id
     *
     * @param int $appId
     * @param int $aclId
     * @param array $input
     * @return \stdClass
     */
    public function update($appId, $aclId, array $input = [])
    {
        $response = $this->client->patch($this->uri($appId, $aclId), [
            'form_params' => ['acl' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all ACLs for current user of application
     *
     * @param int $appId
     * @param array $queryParams
     * @return void
     */
    public function deleteAll($appId = null, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Delete ACL for application by id
     *
     * @param int $appId
     * @param int $aclId
     * @return void
     */
    public function deleteById($appId, $aclId)
    {
        $response = $this->client->delete($this->uri($appId, $aclId));

        $this->handleResponse($response, true);
    }
}
