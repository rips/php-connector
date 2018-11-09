<?php

namespace RIPS\Connector\Requests\Application\Profile;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class SanitiserRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sanitiserId
     * @return string
     */
    protected function uri($appId, $profileId, $sanitiserId = null)
    {
        return is_null($sanitiserId)
            ? "/applications/{$appId}/profiles/{$profileId}/sanitisers"
            : "/applications/{$appId}/profiles/{$profileId}/sanitisers/{$sanitiserId}";
    }

    /**
     * Get all sanitisers for profile profile
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
     * Get specific sanitiser for profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sanitiserId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $profileId, $sanitiserId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId, $sanitiserId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new sanitiser for a profile profile
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
            RequestOptions::JSON => ['sanitiser' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an sanitiser rule for a profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sanitiserId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, $sanitiserId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $profileId, $sanitiserId), [
            RequestOptions::JSON => ['sanitiser' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all sanitisers for a profile profile
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
     * Delete an sanitiser for a profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $sanitiserId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $profileId, $sanitiserId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($profileId) || is_null($sanitiserId)) {
            throw new LibException('appId, profileId, or sanitiserId is null');
        }

        $response = $this->client->delete($this->uri($appId, $profileId, $sanitiserId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
