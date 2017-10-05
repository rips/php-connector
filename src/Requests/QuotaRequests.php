<?php

namespace RIPS\Connector\Requests;

class QuotaRequests extends BaseRequest
{
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
     * Get all acls for a quota
     *
     * @param int $quotaId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAllAcls($quotaId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($quotaId)}/acls", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a quota by id
     *
     * @param int $quotaId
     * @return \stdClass
     */
    public function getById($quotaId)
    {
        $response = $this->client->get($this->uri($quotaId));

        return $this->handleResponse($response);
    }

    /**
     * Get acl for quota by id
     *
     * @param int $quotaId
     * @param int $aclId
     * @return stdClass
     */
    public function getAclById($quotaId, $aclId)
    {
        $response = $this->client->get("{$this->uri($quotaId)}/acls/{$aclId}");

        return $this->handleResponse($response);
    }

    /**
     * Create a new quota
     *
     * @param array $input
     * @return \stdClass
     */
    public function create(array $input)
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['quota' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new acl for a quota
     *
     * @param int $quotaId
     * @param array $input
     * @return stdClass
     */
    public function createAcl($quotaId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($quotaId)}/acls", [
            'form_params' => ['acl' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update existing quota
     *
     * @param int $quotaId
     * @param array $input
     * @return \stdClass
     */
    public function update($quotaId, array $input = [])
    {
        $response = $this->client->patch($this->uri($quotaId), [
            'form_params' => ['quota' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update existing acl for a quota
     *
     * @param int $quotaId
     * @param int $aclId
     * @param array $input
     * @return stdClass
     */
    public function updateAcl($quotaId, $aclId, array $input = [])
    {
        $response = $this->client->patch("{$this->uri($quotaId)}/acls/{$aclId}", [
            'form_params' => ['acl' => $input],
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
        $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete all Acls for a quota
     *
     * @param int $quotaId
     * @param array $queryParams
     * @return void
     */
    public function deleteAllAcls($quotaId, array $queryParams = [])
    {
        $this->client->delete("{$this->uri($quotaId)}/acls", [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete quota by id
     *
     * @param int $quotaId
     * @return void
     */
    public function deleteById($quotaId)
    {
        $this->client->delete($this->uri($quotaId));
    }

    /**
     * Delete an Acl for a quota by id
     *
     * @param int $quotaId
     * @param int $aclId
     * @return void
     */
    public function deleteAclById($quotaId, $aclId)
    {
        $this->client->delete("{$this->uri($quotaId)}/acls/{$aclId}");
    }
}
