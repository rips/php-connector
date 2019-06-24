<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Entities\Response;
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

    protected function browserUri($appId, $scanId, $path): string
    {
        return "/applications/{$appId}/scans/{$scanId}/filebrowser?" . urlencode('path=' . $path);
    }

    /**
     * Get all files for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return Response
     */
    public function getAll($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get files using the file browser by path
     *
     * @param $appId
     * @param $scanId
     * @param $path
     * @return Response
     */
    public function getBrowser($appId, $scanId, $path = '/')
    {
        $response = $this->client->get($this->browserUri($appId, $scanId, $path));

        return $this->handleResponse($response);
    }

    /**
     * Get a file for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $fileId
     * @param array $queryParams
     * @return Response
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
     * @return Response
     */
    public function delete($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $scanId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
