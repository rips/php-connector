<?php

namespace RIPS\Connector\Requests\Application;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Requests\BaseRequest;
use RIPS\Connector\Requests\Application\Custom\IgnoreRequests;
use RIPS\Connector\Requests\Application\Custom\SanitiserRequests;
use RIPS\Connector\Requests\Application\Custom\SinkRequests;
use RIPS\Connector\Requests\Application\Custom\SourceRequests;
use RIPS\Connector\Requests\Application\Custom\ValidatorRequests;

class CustomRequests extends BaseRequest
{
    /**
     * @var IgnoreRequests
     */
    protected $ignoreRequests;

    /**
     * @var SanitiserRequests
     */
    protected $sanitiserRequests;

    /**
     * @var SinkRequests
     */
    protected $sinkRequests;

    /**
     * @var SourceRequests
     */
    protected $sourceRequests;

    /**
     * @var ValidatorRequests
     */
    protected $validatorRequests;

    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $customId
     * @return string
     */
    protected function uri($appId = null, $customId = null)
    {
        if (is_null($appId)) {
            return '/applications/customs/all';
        }

        return is_null($customId)
            ? "/applications/{$appId}/customs"
            : "/applications/{$appId}/customs/{$customId}";
    }

    /**
     * Get all custom profiles for the application
     *
     * @param int $appId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll($appId = null, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a custom profile for an app by id
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new custom profile
     *
     * @param int $appId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create($appId, $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId), [
            RequestOptions::JSON => ['custom' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($appId, $customId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $customId), [
            RequestOptions::JSON => ['custom' => $input],
            'query' => $queryParams,
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
        $response = $this->client->delete($this->uri($appId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Delete a custom profile for an application by id
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Accessor to ignore requests
     *
     * @return IgnoreRequests
     */
    public function ignores()
    {
        if (is_null($this->ignoreRequests)) {
            $this->ignoreRequests = new IgnoreRequests($this->client);
        }

        return $this->ignoreRequests;
    }

    /**
     * Accessor to sanitiser requests
     *
     * @return SanitiserRequests
     */
    public function sanitisers()
    {
        if (is_null($this->sanitiserRequests)) {
            $this->sanitiserRequests = new SanitiserRequests($this->client);
        }

        return $this->sanitiserRequests;
    }

    /**
     * Accessor to sink requests
     *
     * @return SinkRequests
     */
    public function sinks()
    {
        if (is_null($this->sinkRequests)) {
            $this->sinkRequests = new SinkRequests($this->client);
        }

        return $this->sinkRequests;
    }

    /**
     * Accessor to source requests
     *
     * @return SourceRequests
     */
    public function sources()
    {
        if (is_null($this->sourceRequests)) {
            $this->sourceRequests = new SourceRequests($this->client);
        }

        return $this->sourceRequests;
    }

    /**
     * Accessor to validator requests
     *
     * @return ValidatorRequests
     */
    public function validators()
    {
        if (is_null($this->validatorRequests)) {
            $this->validatorRequests = new ValidatorRequests($this->client);
        }

        return $this->validatorRequests;
    }
}
