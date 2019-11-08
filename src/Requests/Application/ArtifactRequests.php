<?php

namespace RIPS\Connector\Requests\Application;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class ArtifactRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $appId
     * @param int|null $artifactId
     * @return string
     */
    private function uri($appId, $artifactId = null)
    {
        return is_null($artifactId)
            ? "/applications/{$appId}/artifacts"
            : "/applications/{$appId}/artifacts/{$artifactId}";
    }

    /**
     * Get all artifacts for an application
     *
     * @param int $appId
     * @param array $queryParams
     * @return Response
     */
    public function getAll($appId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get artifact for application by id
     *
     * @param int $appId
     * @param int $artifactId
     * @param array $queryParams
     * @return Response
     */
    public function getById($appId, $artifactId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $artifactId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all artifacts for an application
     *
     * @param int $appId
     * @param array $queryParams
     * @return Response
     */
    public function deleteAll($appId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete an artifact for an application by id
     *
     * @param int $appId
     * @param int $artifactId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($appId, $artifactId, array $queryParams = [])
    {
        if (is_null($artifactId)) {
            throw new LibException('artifactId is null');
        }

        $response = $this->client->delete($this->uri($appId, $artifactId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new artifact
     *
     * @param int $appId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create($appId, array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId), [
            RequestOptions::JSON => ['artifact' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update artifact for application by id
     *
     * @param int $appId
     * @param int $artifactId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $artifactId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($appId, $artifactId), [
            RequestOptions::JSON => ['artifact' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
