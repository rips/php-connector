<?php

namespace RIPS\Connector\Requests\Application;

use RIPS\Connector\Requests\BaseRequest;

class UploadRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int $uploadId
     * @return string
     */
    private function uri($appId, $uploadId = null)
    {
        return is_null($uploadId)
            ? "/applications/{$appId}/uploads"
            : "/applications/{$appId}/uploads/{$uploadId}";
    }

    /**
     * Get all uploads for an application
     *
     * @param int $appId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll($appId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get upload for application by id
     *
     * @param int $appId
     * @param int $uploadId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $uploadId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $uploadId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Upload a new file
     *
     * @param int $appId
     * @param string $filename
     * @param string $filepath
     * @param array $queryParams
     * @return \stdClass
     */
    public function create($appId, $filename, $filepath, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId), [
            'multipart' => [
                [
                    'name' => 'upload[file]',
                    'contents' => fopen($filepath, 'r'),
                    'filename' => $filename,
                ],
            ],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all uploads for an application
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
     * Delete an upload for an application by id
     *
     * @param int $appId
     * @param int $uploadId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, $uploadId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $uploadId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
