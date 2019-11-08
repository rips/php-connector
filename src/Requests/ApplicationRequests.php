<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\Application\AclRequests;
use RIPS\Connector\Requests\Application\ArtifactRequests;
use RIPS\Connector\Requests\Application\ProfileRequests;
use RIPS\Connector\Requests\Application\ScanRequests;
use RIPS\Connector\Requests\Application\UploadRequests;

class ApplicationRequests extends BaseRequest
{
    /**
     * @var Application\AclRequests
     */
    protected $aclRequests;

    /**
     * @var ProfileRequests
     */
    protected $profileRequests;

    /**
     * @var ScanRequests
     */
    protected $scanRequests;

    /**
     * @var UploadRequests
     */
    protected $uploadRequests;

    /**
     * @var ArtifactRequests
     */
    protected $artifactRequests;

    /**
     * Build a uri for the request
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
     * Get application by id
     *
     * @param int $appId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new application
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['application' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing application
     *
     * @param int $appId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId), [
            RequestOptions::JSON => ['application' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all applications for current user
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
     * Delete application by id
     *
     * @param int $appId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, array $queryParams = [])
    {
        if (is_null($appId)) {
            throw new LibException('appId is null');
        }

        $response = $this->client->delete($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * ACL requests accessor
     *
     * @return Application\AclRequests
     */
    public function acls()
    {
        if (is_null($this->aclRequests)) {
            $this->aclRequests = new AclRequests($this->client);
        }

        return $this->aclRequests;
    }

    /**
     * Profile requests accessor
     *
     * @return ProfileRequests
     */
    public function profiles()
    {
        if (is_null($this->profileRequests)) {
            $this->profileRequests = new ProfileRequests($this->client);
        }

        return $this->profileRequests;
    }

    /**
     * Scan requests accessor
     *
     * @return ScanRequests
     */
    public function scans()
    {
        if (is_null($this->scanRequests)) {
            $this->scanRequests = new ScanRequests($this->client);
        }

        return $this->scanRequests;
    }

    /**
     * Upload requests accessor
     *
     * @return UploadRequests
     */
    public function uploads()
    {
        if (is_null($this->uploadRequests)) {
            $this->uploadRequests = new UploadRequests($this->client);
        }

        return $this->uploadRequests;
    }

    /**
     * Artifact requests accessor
     *
     * @return ArtifactRequests
     */
    public function artifacts()
    {
        if (is_null($this->artifactRequests)) {
            $this->artifactRequests = new ArtifactRequests($this->client);
        }

        return $this->artifactRequests;
    }
}
