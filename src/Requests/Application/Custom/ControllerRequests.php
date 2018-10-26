<?php

namespace RIPS\Connector\Requests\Application\Custom;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class ControllerRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $customId
     * @param int $controllerId
     * @return string
     */
    protected function uri($appId, $customId, $controllerId = null)
    {
        return is_null($controllerId)
            ? "/applications/{$appId}/customs/{$customId}/controllers"
            : "/applications/{$appId}/customs/{$customId}/controllers/{$controllerId}";
    }

    /**
     * Get all controllers for custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get specific controller for custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $controllerId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $customId, $controllerId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId, $controllerId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new controller for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create($appId, $customId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $customId), [
            RequestOptions::JSON => ['controller' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a controller rule for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $controllerId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($appId, $customId, $controllerId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $customId, $controllerId), [
            RequestOptions::JSON => ['controller' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all controllers for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return void
     */
    public function deleteAll($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Delete a controller for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $controllerId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, $customId, $controllerId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($customId) || is_null($controllerId)) {
            throw new LibException('appId, customId, or controllerId is null');
        }

        $response = $this->client->delete($this->uri($appId, $customId, $controllerId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
