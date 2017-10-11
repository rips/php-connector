<?php

namespace RIPS\Connector\Requests\Application\Custom;

use RIPS\Connector\Requests\BaseRequest;

class SanitiserRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $customId
     * @param int $sanitiserId
     * @return string
     */
    protected function uri($appId, $customId, $sanitiserId = null)
    {
        return is_null($sanitiserId)
            ? "/applications/{$appId}/customs/{$customId}/sanitisers"
            : "/applications/{$appId}/customs/{$customId}/sanitisers/{$sanitiserId}";
    }

    /**
     * Get all sanitisers for custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAll($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get specific sanitiser for custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sanitiserId
     * @return stdClass
     */
    public function getById($appId, $customId, $sanitiserId)
    {
        $response = $this->client->get($this->uri($appId, $customId, $sanitiserId));

        return $this->handleResponse($response);
    }

    /**
     * Create a new sanitiser for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @return stdClass
     */
    public function create($appId, $customId, array $input = [])
    {
        $response = $this->client->post($this->uri($appId, $customId), [
            'form_params' => ['sanitiser' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an sanitiser rule for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sanitiserId
     * @param array $input
     * @return stdClass
     */
    public function update($appId, $customId, $sanitiserId, array $input = [])
    {
        $response = $this->client->patch($this->uri($appId, $customId, $sanitiserId), [
            'form_params' => ['sanitiser' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all sanitisers for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return void
     */
    public function deleteAll($appId, $customId, array $queryParams = [])
    {
        $this->client->delete($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete an sanitiser for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sanitiserId
     * @return void
     */
    public function deleteById($appId, $customId, $sanitiserId)
    {
        $this->client->delete($this->uri($appId, $customId, $sanitiserId));
    }
}
