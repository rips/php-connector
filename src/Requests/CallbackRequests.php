<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;

class CallbackRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $callbackId
     * @return string
     */
    public function uri($callbackId = null)
    {
        return is_null($callbackId) ? '/callbacks' : "/callbacks/{$callbackId}";
    }

    /**
     * Get all callbacks
     *
     * @param array $queryParams
     * @return Response
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a callback by id
     *
     * @param int $callbackId
     * @param array $queryParams
     * @return Response
     */
    public function getById($callbackId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($callbackId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new callback
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['callback' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a callback by id
     *
     * @param int $callbackId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($callbackId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($callbackId), [
            RequestOptions::JSON => ['callback' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all callbacks
     *
     * @param array $queryParams
     * @return Response
     */
    public function deleteAll(array $queryParams = [])
    {
        $response = $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete a callback by id
     *
     * @param int $callbackId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($callbackId, array $queryParams = [])
    {
        if (is_null($callbackId)) {
            throw new LibException('callbackId is null');
        }

        $response = $this->client->delete($this->uri($callbackId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
