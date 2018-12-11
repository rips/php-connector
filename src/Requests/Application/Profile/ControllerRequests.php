<?php

namespace RIPS\Connector\Requests\Application\Profile;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class ControllerRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @param int $controllerId
     * @return string
     */
    protected function uri($appId, $profileId, $controllerId = null)
    {
        return is_null($controllerId)
            ? "/applications/{$appId}/profiles/{$profileId}/controllers"
            : "/applications/{$appId}/profiles/{$profileId}/controllers/{$controllerId}";
    }

    /**
     * Get all controllers for profile
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
     * Get specific controller for profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $controllerId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $profileId, $controllerId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId, $controllerId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new controller for a profile
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
            RequestOptions::JSON => ['controller' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a controller rule for a profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $controllerId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, $controllerId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $profileId, $controllerId), [
            RequestOptions::JSON => ['controller' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all controllers for a profile
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
     * Delete a controller for a profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $controllerId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $profileId, $controllerId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($profileId) || is_null($controllerId)) {
            throw new LibException('appId, profileId, or controllerId is null');
        }

        $response = $this->client->delete($this->uri($appId, $profileId, $controllerId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
