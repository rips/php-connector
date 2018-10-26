<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\Application\AclRequests;
use RIPS\Connector\Requests\Application\CustomRequests;
use RIPS\Connector\Requests\Application\ScanRequests;
use RIPS\Connector\Requests\Application\UploadRequests;

class ApplicationRequests extends BaseRequest
{
    /**
     * @var Application\AclRequests
     */
    protected $aclRequests;

    /**
     * @var CustomRequests
     */
    protected $customRequests;

    /**
     * @var ScanRequests
     */
    protected $scanRequests;

    /**
     * @var UploadRequests
     */
    protected $uploadRequests;

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
     * Get application by id
     *
     * @param int $appId
     * @param array $queryParams
     * @return \stdClass
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
     * @return \stdClass
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
     * @return \stdClass
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
     * Delete application by id
     *
     * @param int $appId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, array $queryParams = [])
    {
        if (is_null($appId)) {
            throw new LibException('appId is null');
        }

        $response = $this->client->delete($this->uri($appId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
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
     * Custom requests accessor
     *
     * @return CustomRequests
     */
    public function customs()
    {
        if (is_null($this->customRequests)) {
            $this->customRequests = new CustomRequests($this->client);
        }

        return $this->customRequests;
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
}
