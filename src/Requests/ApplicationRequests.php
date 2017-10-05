<?php

namespace RIPS\Connector\Requests;

class ApplicationRequests extends BaseRequest
{
    /**
     * Build a uri for the requests
     *
     * @param int $appId
     * @return string
     */
    private function uri($appId = null)
    {
        return is_null($appId) ? '/applications' : "/applications/{$appId}";
    }

    /**
     * Get all applications
     *
     * @param array $queryParams
     * @return \stdClass
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get ACLs for an application
     *
     * @param int $appId
     * @param array queryParams
     * @return void
     */
    public function getAllAcls($appId, array $queryParams = [])
    {
        $uri = is_null($appId) ? "{$this->uri()}/acls/own" : "{$this->uri($appId)}/acls";

        $response = $this->client->get($uri, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get application by id
     *
     * @param int $appId
     * @return \stdClass
     */
    public function getById($appId)
    {
        $response = $this->client->get($this->uri($appId));

        return $this->handleResponse($response);
    }

    /**
     * Get ACL for application by id
     *
     * @param int $appId
     * @param int $aclId
     * @return stdClass
     */
    public function getAclById($appId, $aclId)
    {
        $response = $this->client->get("{$this->uri($appId)}/acls/{$aclId}");

        return $this->handleResponse($response);
    }


    /**
     * Create a new application
     *
     * @param array $input
     * @return \stdClass
     */
    public function create(array $input = [])
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['application' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new ACL for an application
     *
     * @param int $appId
     * @param array $input
     * @return stdClass
     */
    public function createAcl($appId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId)}/acls", [
            'form_params' => ['acl' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing application
     *
     * @param int $appId
     * @param array $input
     * @return \stdClass
     */
    public function update($appId, array $input = [])
    {
        $response = $this->client->patch($this->uri($appId), [
            'form_params' => ['application' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update ACL for app by id
     *
     * @param int $appId
     * @param int $aclId
     * @param array $input
     * @return stdClass
     */
    public function updateAcl($appId, $aclId, array $input = [])
    {
        $response = $this->client->patch("{$this->uri($appId)}/acls/{$aclId}", [
            'form_params' => ['acl' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all applications for current user
     *
     * @param array $queryParams
     * @return void
     */
    public function deleteAll(array $queryParams = [])
    {
        $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete all Acls for current user of application
     *
     * @param int $appId
     * @param array $queryParams
     * @return stdClass
     */
    public function deleteAllAcls($appId = null, array $queryParams = [])
    {
        $this->client->delete("{$this->uri($appId)}/acls", [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete application by id
     *
     * @param int $appId
     * @return void
     */
    public function deleteById($appId)
    {
        $this->client->delete($this->uri($appId));
    }

    /**
     * Delete ACL for application by id
     *
     * @param int $appId
     * @param int $aclId
     * @return void
     */
    public function deleteAclById($appId, $aclId)
    {
        $this->client->delete("{$this->uri($appId)}/acls/{$aclId}");
    }
}
