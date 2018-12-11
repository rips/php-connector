<?php

namespace RIPS\Connector\Requests\Application\Profile;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class SanitizerRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sanitizerId
     * @return string
     */
    protected function uri($appId, $profileId, $sanitizerId = null)
    {
        return is_null($sanitizerId)
            ? "/applications/{$appId}/profiles/{$profileId}/sanitizers"
            : "/applications/{$appId}/profiles/{$profileId}/sanitizers/{$sanitizerId}";
    }

    /**
     * Get all sanitizers for profile
     *
     * @param int $appId
     * @param int $profileId
     * @param array $queryParams
     * @return Response
     */
    public function getAll($appId, $profileId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get specific sanitizer for profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sanitizerId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $profileId, $sanitizerId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId, $sanitizerId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new sanitizer for a profile
     *
     * @param int $appId
     * @param int $profileId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create($appId, $profileId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $profileId), [
            RequestOptions::JSON => ['sanitizer' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an sanitizer rule for a profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sanitizerId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, $sanitizerId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $profileId, $sanitizerId), [
            RequestOptions::JSON => ['sanitizer' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all sanitizers for a profile
     *
     * @param int $appId
     * @param int $profileId
     * @param array $queryParams
     * @return Response
     */
    public function deleteAll($appId, $profileId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $profileId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete an sanitizer for a profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sanitizerId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $profileId, $sanitizerId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($profileId) || is_null($sanitizerId)) {
            throw new LibException('appId, profileId, or sanitizerId is null');
        }

        $response = $this->client->delete($this->uri($appId, $profileId, $sanitizerId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
