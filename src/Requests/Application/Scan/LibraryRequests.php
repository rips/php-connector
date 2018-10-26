<?php

namespace RIPS\Connector\Requests\Application\Scan;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class LibraryRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $libraryId
     * @return string
     */
    protected function uri($appId, $scanId, $libraryId = null)
    {
        return is_null($libraryId)
            ? "/applications/{$appId}/scans/{$scanId}/libraries"
            : "/applications/{$appId}/scans/{$scanId}/libraries/{$libraryId}";
    }

    /**
     * Get all libraries for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get library for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $libraryId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $scanId, $libraryId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $libraryId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a library for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create($appId, $scanId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $scanId), [
            RequestOptions::JSON => ['library' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
    /**
     * Update a library for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $libraryId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($appId, $scanId, $libraryId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $scanId, $libraryId), [
            RequestOptions::JSON => ['library' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all libraries
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return void
     */
    public function deleteAll($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $scanId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Delete a library by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $libraryId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, $scanId, $libraryId, array $queryParams = [])
    {
        if (is_null($appId) || is_null($scanId) || is_null($libraryId)) {
            throw new LibException('appId, scanId, or libraryId is null');
        }

        $response = $this->client->delete($this->uri($appId, $scanId, $libraryId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
