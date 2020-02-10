<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;

class ServerRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $serverId
     * @return string
     */
    private function uri($serverId = null)
    {
        return is_null($serverId) ? '/servers' : "/servers/{$serverId}";
    }

    /**
     * Get all servers
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
     * Get server by id
     *
     * @param int $serverId
     * @param array $queryParams
     * @return Response
     */
    public function getById($serverId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($serverId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new server
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['server' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing server
     *
     * @param int $serverId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($serverId, array $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($serverId), [
            RequestOptions::JSON => ['server' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Ping a server
     *
     * @param int $serverId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function ping($serverId, array $input, array $queryParams = [])
    {
        $options = [
            'query' => $queryParams,
        ];

        if (!empty($input)) {
            $options[RequestOptions::JSON] = ['system' => $input];
        }

        $response = $this->client->patch($this->uri($serverId) . '/ping', $options);

        return $this->handleResponse($response);
    }
}
