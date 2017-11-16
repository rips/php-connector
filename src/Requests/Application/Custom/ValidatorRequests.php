<?php

namespace RIPS\Connector\Requests\Application\Custom;

use RIPS\Connector\Requests\BaseRequest;

class ValidatorRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $customId
     * @param int $validatorId
     * @return string
     */
    protected function uri($appId, $customId, $validatorId = null)
    {
        return is_null($validatorId)
            ? "/applications/{$appId}/customs/{$customId}/validators"
            : "/applications/{$appId}/customs/{$customId}/validators/{$validatorId}";
    }

    /**
     * Get all validators for custom profile
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
     * Get specific validator for custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $validatorId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $customId, $validatorId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId, $validatorId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new validator for a custom profile
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
            'form_params' => ['validator' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an validator rule for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $validatorId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($appId, $customId, $validatorId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $customId, $validatorId), [
            'form_params' => ['validator' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all validators for a custom profile
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
     * Delete an validator for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $validatorId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, $customId, $validatorId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $customId, $validatorId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
