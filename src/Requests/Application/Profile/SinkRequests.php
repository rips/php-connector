<?php

namespace RIPS\Connector\Requests\Application\Profile;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class SinkRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sinkId
     * @return string
     */
    protected function uri($appId, $profileId, $sinkId = null)
    {
        return is_null($sinkId)
            ? "/applications/{$appId}/profiles/{$profileId}/sinks"
            : "/applications/{$appId}/profiles/{$profileId}/sinks/{$sinkId}";
    }

    /**
     * Get all sinks for profile profile
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
     * Get specific sink for profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sinkId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $profileId, $sinkId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId, $sinkId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new sink for a profile profile
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
            RequestOptions::JSON => ['sink' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an sink rule for a profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sinkId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, $sinkId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $profileId, $sinkId), [
            RequestOptions::JSON => ['sink' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all sinks for a profile profile
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
     * Delete an sink for a profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sinkId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $profileId, $sinkId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($profileId) || is_null($sinkId)) {
            throw new LibException('appId, profileId, or sinkId is null');
        }

        $response = $this->client->delete($this->uri($appId, $profileId, $sinkId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
