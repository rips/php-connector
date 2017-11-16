<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Requests\BaseRequest;

class FileRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param int $fileId
     * @return string
     */
    protected function uri($appId, $scanId, $fileId = null)
    {
        return is_null($fileId)
            ? "/applications/{$appId}/scans/{$scanId}/files"
            : "/applications/{$appId}/scans/{$scanId}/files/{$fileId}";
    }

    /**
     * Get all files for a scan
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
     * Get a file for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $fileId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $scanId, $fileId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, $fileId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete the source code of scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return void
     */
    public function delete($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $scanId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
