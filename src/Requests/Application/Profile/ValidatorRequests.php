<?php

namespace RIPS\Connector\Requests\Application\Profile;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class ValidatorRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @param int $validatorId
     * @return string
     */
    protected function uri($appId, $profileId, $validatorId = null)
    {
        return is_null($validatorId)
            ? "/applications/{$appId}/profiles/{$profileId}/validators"
            : "/applications/{$appId}/profiles/{$profileId}/validators/{$validatorId}";
    }

    /**
     * Get all validators for profile profile
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
     * Get specific validator for profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $validatorId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $profileId, $validatorId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId, $validatorId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new validator for a profile profile
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
            RequestOptions::JSON => ['validator' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an validator rule for a profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $validatorId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, $validatorId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $profileId, $validatorId), [
            RequestOptions::JSON => ['validator' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all validators for a profile profile
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
     * Delete an validator for a profile profile by id
     *
     * @param int $appId
     * @param int $profileId
     * @param int $validatorId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $profileId, $validatorId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($profileId) || is_null($validatorId)) {
            throw new LibException('appId, profileId, or validatorId is null');
        }

        $response = $this->client->delete($this->uri($appId, $profileId, $validatorId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
