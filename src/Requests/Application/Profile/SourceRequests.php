<?php

namespace RIPS\Connector\Requests\Application\Profile;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class SourceRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sourceId
     * @return string
     */
    protected function uri($appId, $profileId, $sourceId = null)
    {
        return is_null($sourceId)
            ? "/applications/{$appId}/profiles/{$profileId}/sources"
            : "/applications/{$appId}/profiles/{$profileId}/sources/{$sourceId}";
    }

    /**
     * Get all sources for profile
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
     * Get specific source for profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sourceId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $profileId, $sourceId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId, $sourceId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new source for a profile
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
            RequestOptions::JSON => ['source' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an source rule for a profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sourceId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, $sourceId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $profileId, $sourceId), [
            RequestOptions::JSON => ['source' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all sources for a profile
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
     * Delete an source for a profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sourceId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $profileId, $sourceId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($profileId) || is_null($sourceId)) {
            throw new LibException('appId, profileId, or sourceId is null');
        }

        $response = $this->client->delete($this->uri($appId, $profileId, $sourceId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
