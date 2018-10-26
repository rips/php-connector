<?php

namespace RIPS\Connector\Requests\Application\Custom;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class SinkRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $customId
     * @param int $sinkId
     * @return string
     */
    protected function uri($appId, $customId, $sinkId = null)
    {
        return is_null($sinkId)
            ? "/applications/{$appId}/customs/{$customId}/sinks"
            : "/applications/{$appId}/customs/{$customId}/sinks/{$sinkId}";
    }

    /**
     * Get all sinks for custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return Response
     */
    public function getAll($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get specific sink for custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sinkId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $customId, $sinkId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId, $sinkId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new sink for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create($appId, $customId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $customId), [
            RequestOptions::JSON => ['sink' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an sink rule for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sinkId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $customId, $sinkId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $customId, $sinkId), [
            RequestOptions::JSON => ['sink' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all sinks for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return Response
     */
    public function deleteAll($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete an sink for a custom profile by id
     *
     * @param int $appId
     * @param int $customId
     * @param int $sinkId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $customId, $sinkId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($customId) || is_null($sinkId)) {
            throw new LibException('appId, customId, or sinkId is null');
        }

        $response = $this->client->delete($this->uri($appId, $customId, $sinkId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
