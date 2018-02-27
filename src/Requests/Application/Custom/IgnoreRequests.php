<?php

namespace RIPS\Connector\Requests\Application\Custom;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Requests\BaseRequest;

class IgnoreRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $customId
     * @param int $ignoreId
     * @return string
     */
    protected function uri($appId, $customId, $ignoreId = null)
    {
        return is_null($ignoreId)
            ? "/applications/{$appId}/customs/{$customId}/ignores"
            : "/applications/{$appId}/customs/{$customId}/ignores/{$ignoreId}";
    }

    /**
     * Get all ignores for custom profile
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
     * Get specific ignore for custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $ignoreId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $customId, $ignoreId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId, $ignoreId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new ignore for a custom profile
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
            RequestOptions::JSON => ['ignore' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an ignore rule for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $ignoreId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($appId, $customId, $ignoreId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $customId, $ignoreId), [
            RequestOptions::JSON => ['ignore' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all ignores for a custom profile
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

        $this->handleResponse($response, null);
    }

    /**
     * Delete an ignore for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $ignoreId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, $customId, $ignoreId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $customId, $ignoreId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, null);
    }
}
