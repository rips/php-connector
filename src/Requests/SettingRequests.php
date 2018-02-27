<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;

class SettingRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param string $key
     * @return string
     */
    public function uri($key = null)
    {
        return is_null($key) ? '/settings' : "/settings/{$key}";
    }

    /**
     * Get all settings
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
     * Get a setting by key
     *
     * @param string $key
     * @param array $queryParams
     * @return \stdClass
     */
    public function getByKey($key, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($key), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create or update a setting
     *
     * @param string $key
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function createOrUpdate($key, array $input, array $queryParams = [])
    {
        $response = $this->client->put($this->uri($key), [
            RequestOptions::JSON => ['setting' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all settings
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
     * Delete setting by key
     *
     * @param string $key
     * @param array $queryParams
     * @return void
     */
    public function deleteByKey($key, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($key), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
