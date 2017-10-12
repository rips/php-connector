<?php

namespace RIPS\Connector\Requests;

class SettingsRequests extends BaseRequest
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
     * @return \stdClass
     */
    public function getByKey($key)
    {
        $response = $this->client->get($this->uri($key));

        return $this->handleResponse($response);
    }

    /**
     * Create or update a setting
     *
     * @param string $key
     * @param array $input
     * @return \stdClass
     */
    public function createOrUpdate($key, array $input)
    {
        $response = $this->client->put($this->uri($key), [
            'form_params' => ['setting' => $input],
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
        $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete setting by key
     *
     * @param string $key
     * @return void
     */
    public function deleteByKey($key)
    {
        $this->client->delete($this->uri($key));
    }
}
