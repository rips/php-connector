<?php

namespace RIPS\Connector\Requests\Application\Profile;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class IgnoredCodeRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @param int $ignoreId
     * @return string
     */
    protected function uri($appId, $profileId, $ignoreId = null)
    {
        return is_null($ignoreId)
            ? "/applications/{$appId}/profiles/{$profileId}/ignoredcodes"
            : "/applications/{$appId}/profiles/{$profileId}/ignoredcodes/{$ignoreId}";
    }

    /**
     * Get all ignored codes for profile
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
     * Get specific ignored code for profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $ignoreId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $profileId, $ignoreId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId, $ignoreId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new ignored code for a profile
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
            RequestOptions::JSON => ['ignored_code' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update ignored code for a profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $ignoreId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, $ignoreId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $profileId, $ignoreId), [
            RequestOptions::JSON => ['ignored_code' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all ignored codes for a profile
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
     * Delete ignored code for a profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $ignoreId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $profileId, $ignoreId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($profileId) || is_null($ignoreId)) {
            throw new LibException('appId, profileId, or ignoreId is null');
        }

        $response = $this->client->delete($this->uri($appId, $profileId, $ignoreId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
