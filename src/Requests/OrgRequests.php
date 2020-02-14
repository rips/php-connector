<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;

class OrgRequests extends BaseRequest
{
    /**
     * @var \RIPS\Connector\Requests\Organization\SettingRequests
     */
    protected $settingRequests;

    /**
     * Build a URI for the request
     *
     * @param int $orgId
     * @return string
     */
    protected function uri($orgId = null)
    {
        return is_null($orgId) ? '/organizations' : "/organizations/{$orgId}";
    }

    /**
     * Get all organizations
     *
     * @param array $queryParams
     * @return Response
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get an organization by id
     *
     * @param int $orgId
     * @param array $queryParams
     * @return Response
     */
    public function getById($orgId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($orgId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new organization
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['organization' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Invite a new organization for trial
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function invite(array $input, array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri()}/invite/ui", [
            RequestOptions::JSON => ['invitation' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing organization
     *
     * @param int $orgId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($orgId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($orgId), [
            RequestOptions::JSON => ['organization' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all organizations
     *
     * @param array $queryParams
     * @return Response
     */
    public function deleteAll(array $queryParams = [])
    {
        $response = $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete an organization by id
     *
     * @param int $orgId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($orgId, array $queryParams = [])
    {
        if (is_null($orgId)) {
            throw new LibException('orgId is null');
        }

        $response = $this->client->delete($this->uri($orgId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Setting requests accessor.
     *
     * @return Organization\SettingRequests
     */
    public function settings()
    {
        if (is_null($this->settingRequests)) {
            $this->settingRequests = new \RIPS\Connector\Requests\Organization\SettingRequests($this->client);
        }

        return $this->settingRequests;
    }
}
