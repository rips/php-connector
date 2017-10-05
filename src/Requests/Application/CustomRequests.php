<?php

namespace RIPS\Connector\Requests\Application;

use RIPS\Connector\Requests\BaseRequest;

class CustomRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $customId
     * @return string
     */
    protected function uri($appId, $customId = null)
    {
        return is_null($customId)
            ? "/applications/{$appId}/customs"
            : "/applications/{$appId}/customs/{$customId}";
    }

    /**
     * Get all custom profiles for the application
     *
     * @param int $appId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAll($appId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get all ignores for custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAllIgnores($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/ignores", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get all sanitisers for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAllSanitisers($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/sanitisers", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get all sinks for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAllSinks($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/sinks", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get all sources for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAllSources($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/sources", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get all all validators for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getAllValidators($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/validators", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a custom profile for an app by id
     *
     * @param int $appId
     * @param int $customId
     * @return stdClass
     */
    public function getById($appId, $customId)
    {
        $response = $this->client->get($this->uri($appId, $customId));

        return $this->handleResponse($response);
    }

    /**
     * Get specific ignore for custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $ignoreId
     * @return stdClass
     */
    public function getIgnoreById($appId, $customId, $ignoreId)
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/ignores/{$ignoreId}");

        return $this->handleResponse($response);
    }

    /**
     * Get a sanitizer for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sanitiserId
     * @return stdClass
     */
    public function getSanitiserById($appId, $customId, $sanitiserId)
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/sanitisers/{$sanitiserId}");

        return $this->handleResponse($response);
    }


    /**
     * Get a sink for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sinkId
     * @return stdClass
     */
    public function getSinkById($appId, $customId, $sinkId)
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/sinks/{$sinkId}");

        return $this->handleResponse($response);
    }

    /**
     * Get a source for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sourceId
     * @return stdClass
     */
    public function getSourceById($appId, $customId, $sourceId)
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/sources/{$sourceId}");

        return $this->handleResponse($response);
    }

    /**
     * Get a validator for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $validatorId
     * @return stdClass
     */
    public function getValidatorById($appId, $customId, $validatorId)
    {
        $response = $this->client->get("{$this->uri($appId, $customId)}/validators/{$validatorId}");

        return $this->handleResponse($response);
    }

    /**
     * Create a new custom profile
     *
     * @param int $appId
     * @param array $input
     * @return stdClass
     */
    public function create($appId, $input)
    {
        $response = $this->client->post($this->uri($appId), [
            'form_params' => ['custom' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new ignore for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @return stdClass
     */
    public function createIgnore($appId, $customId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId, $customId)}/ignores", [
            'form_params' => ['ignore' => $input],
        ]);

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
    public function createSanitiser($appId, $customId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId, $customId)}/sanitisers", [
            'form_params' => ['sanitiser' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new sink for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @return stdClass
     */
    public function createSink($appId, $customId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId, $customId)}/sinks", [
            'form_params' => ['sink' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new source for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @return stdClass
     */
    public function createSource($appId, $customId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId, $customId)}/sources", [
            'form_params' => ['source' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new validator for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @return stdClass
     */
    public function createValidator($appId, $customId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId, $customId)}/validators", [
            'form_params' => ['validator' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @return stdClass
     */
    public function update($appId, $customId, array $input = [])
    {
        $response = $this->client->patch($this->uri($appId, $customId), [
            'form_params' => ['custom' => $input],
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
     * @return stdClass
     */
    public function updateIgnore($appId, $customId, $ignoreId, array $input = [])
    {
        $response = $this->client->patch("{$this->uri($appId, $customId)}/ignores/{$ignoreId}", [
            'form_params' => ['ignore' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a sanitiser for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sanitiserId
     * @param array $input
     * @return stdClass
     */
    public function updateSanitiser($appId, $customId, $sanitiserId, array $input = [])
    {
        $response = $this->client->patch("{$this->uri($appId, $customId)}/sanitisers/{$sanitiserId}", [
            'form_params' => ['sanitiser' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a sink for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sinkId
     * @param array $input
     * @return stdClass
     */
    public function updateSink($appId, $customId, $sinkId, array $input = [])
    {
        $response = $this->client->patch("{$this->uri($appId, $customId)}/sinks/{$sinkId}", [
            'form_params' => ['sink' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a source for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sourceId
     * @param array $input
     * @return stdClass
     */
    public function updateSource($appId, $customId, $sourceId, array $input = [])
    {
        $response = $this->client->patch("{$this->uri($appId, $customId)}/sources/{$sourceId}", [
            'form_params' => ['source' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a validator for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $validatorId
     * @param array $input
     * @return stdClass
     */
    public function updateValidator($appId, $customId, $validatorId, array $input = [])
    {
        $response = $this->client->patch("{$this->uri($appId, $customId)}/validators/{$validatorId}", [
            'form_params' => ['validator' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all custom profiles for application
     *
     * @param int $appId
     * @param array $queryParams
     * @return void
     */
    public function deleteAll($appId, array $queryParams = [])
    {
        $this->client->delete($this->uri($appId), [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete all ignores for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return void
     */
    public function deleteAllIgnores($appId, $customId, array $queryParams = [])
    {
        $this->client->delete("{$this->uri($appId, $customId)}/ignores", [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete all sanitisers for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return stdClass
     */
    public function deleteAllSanitisers($appId, $customId, array $queryParams = [])
    {
        $this->client->delete("{$this->uri($appId, $customId)}/sanitisers", [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete all sinks for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return void
     */
    public function deleteAllSinks($appId, $customId, array $queryParams = [])
    {
        $this->client->delete("{$this->uri($appId, $customId)}/sinks", [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete all sources for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return void
     */
    public function deleteAllSources($appId, $customId, array $queryParams = [])
    {
        $this->client->delete("{$this->uri($appId, $customId)}/sources", [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete all validators for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return void
     */
    public function deleteAllValidators($appId, $customId, array $queryParams = [])
    {
        $this->client->delete("{$this->uri($appId, $customId)}/validators", [
            'query' => $queryParams,
        ]);
    }

    /**
     * Delete a custom profile for an application by id
     *
     * @param int $appId
     * @param int $customId
     * @return void
     */
    public function deleteById($appId, $customId)
    {
        $this->client->delete($this->uri($appId, $customId));
    }

    /**
     * Delete an ignore for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $ignoreId
     * @return void
     */
    public function deleteIgnoreById($appId, $customId, $ignoreId)
    {
        $this->client->delete("{$this->uri($appId, $customId)}/ignores/{$ignoreId}");
    }

    /**
     * Delete a sanitiser for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sanitiserId
     * @return stdClass
     */
    public function deleteSanitiserById($appId, $customId, $sanitiserId)
    {
        $this->client->delete("{$this->uri($appId, $customId)}/sanitisers/{$sanitiserId}");
    }

    /**
     * Delete a sink for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sinkId
     * @return void
     */
    public function deleteSinkById($appId, $customId, $sinkId)
    {
        $this->client->delete("{$this->uri($appId, $customId)}/sinks/{$sinkId}");
    }

    /**
     * Delete a source for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sourceId
     * @return void
     */
    public function deleteSourceById($appId, $customId, $sourceId)
    {
        $this->client->delete("{$this->uri($appId, $customId)}/sources/{$sourceId}");
    }

    /**
     * Delete a validator for custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $validatorId
     * @return void
     */
    public function deleteValidatorById($appId, $customId, $validatorId)
    {
        $this->client->delete("{$this->uri($appId, $customId)}/validators/{$validatorId}");
    }
}
