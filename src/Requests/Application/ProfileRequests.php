<?php

namespace RIPS\Connector\Requests\Application;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\Application\Profile\IgnoredCodeRequests;
use RIPS\Connector\Requests\Application\Profile\IgnoredLocationRequests;
use RIPS\Connector\Requests\BaseRequest;
use RIPS\Connector\Requests\Application\Profile\SanitizerRequests;
use RIPS\Connector\Requests\Application\Profile\SettingRequests;
use RIPS\Connector\Requests\Application\Profile\SinkRequests;
use RIPS\Connector\Requests\Application\Profile\SourceRequests;
use RIPS\Connector\Requests\Application\Profile\ValidatorRequests;
use RIPS\Connector\Requests\Application\Profile\ControllerRequests;

class ProfileRequests extends BaseRequest
{
    /**
     * @var IgnoredCodeRequests
     */
    protected $ignoredCodeRequests;

    /**
     * @var IgnoredLocationRequests
     */
    protected $ignoredLocationRequests;

    /**
     * @var SanitizerRequests
     */
    protected $sanitizerRequests;

    /**
     * @var SettingRequests
     */
    protected $settingRequests;

    /**
     * @var SinkRequests
     */
    protected $sinkRequests;

    /**
     * @var SourceRequests
     */
    protected $sourceRequests;

    /**
     * @var ValidatorRequests
     */
    protected $validatorRequests;

    /**
     * @var ControllerRequests
     */
    protected $controllerRequests;

    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @param bool $clone
     * @return string
     */
    protected function uri($appId = null, $profileId = null, $clone = false)
    {
        if (is_null($appId)) {
            return '/applications/profiles/all';
        }

        if (is_null($profileId)) {
            return "/applications/{$appId}/profiles";
        }

        if (!$clone) {
            return "/applications/{$appId}/profiles/{$profileId}";
        }

        return "/applications/{$appId}/profiles/{$profileId}/clone";
    }

    /**
     * Get all profiles for the application
     *
     * @param int $appId
     * @param array $queryParams
     * @return Response
     */
    public function getAll($appId = null, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a profile for an app by id
     *
     * @param int $appId
     * @param int $profileId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $profileId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new profile
     *
     * @param int $appId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create($appId, $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId), [
            RequestOptions::JSON => ['profile' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Clone a existing profile
     *
     * @param int $appId
     * @param int $profileId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function cloneById($appId, $profileId, $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $profileId, true), [
            RequestOptions::JSON => ['profile' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing profile
     *
     * @param int $appId
     * @param int $profileId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $profileId), [
            RequestOptions::JSON => ['profile' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all profiles for application
     *
     * @param int $appId
     * @param array $queryParams
     * @return Response
     */
    public function deleteAll($appId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete a profile for an application by id
     *
     * @param int $appId
     * @param int $profileId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $profileId, array $queryParams = [])
    {
        if (is_null($appId)) {
            throw new LibException('appId is null');
        }

        $response = $this->client->delete($this->uri($appId, $profileId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Accessor to ignored code requests
     *
     * @return IgnoredCodeRequests
     */
    public function ignoredCodes()
    {
        if (is_null($this->ignoredCodeRequests)) {
            $this->ignoredCodeRequests = new IgnoredCodeRequests($this->client);
        }

        return $this->ignoredCodeRequests;
    }

    /**
     * Accessor to ignored location requests
     *
     * @return IgnoredLocationRequests
     */
    public function ignoredLocations()
    {
        if (is_null($this->ignoredLocationRequests)) {
            $this->ignoredLocationRequests = new IgnoredLocationRequests($this->client);
        }

        return $this->ignoredLocationRequests;
    }

    /**
     * Accessor to sanitizer requests
     *
     * @return SanitizerRequests
     */
    public function sanitizers()
    {
        if (is_null($this->sanitizerRequests)) {
            $this->sanitizerRequests = new SanitizerRequests($this->client);
        }

        return $this->sanitizerRequests;
    }

    /**
     * Accessor to setting requests
     *
     * @return SettingRequests
     */
    public function settings()
    {
        if (is_null($this->settingRequests)) {
            $this->settingRequests = new SettingRequests($this->client);
        }

        return $this->settingRequests;
    }

    /**
     * Accessor to sink requests
     *
     * @return SinkRequests
     */
    public function sinks()
    {
        if (is_null($this->sinkRequests)) {
            $this->sinkRequests = new SinkRequests($this->client);
        }

        return $this->sinkRequests;
    }

    /**
     * Accessor to source requests
     *
     * @return SourceRequests
     */
    public function sources()
    {
        if (is_null($this->sourceRequests)) {
            $this->sourceRequests = new SourceRequests($this->client);
        }

        return $this->sourceRequests;
    }

    /**
     * Accessor to validator requests
     *
     * @return ValidatorRequests
     */
    public function validators()
    {
        if (is_null($this->validatorRequests)) {
            $this->validatorRequests = new ValidatorRequests($this->client);
        }

        return $this->validatorRequests;
    }

    /**
     * Accessor to controller requests
     *
     * @return ControllerRequests
     */
    public function controllers()
    {
        if (is_null($this->controllerRequests)) {
            $this->controllerRequests = new ControllerRequests($this->client);
        }

        return $this->controllerRequests;
    }
}
