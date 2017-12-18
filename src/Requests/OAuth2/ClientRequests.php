<?php

namespace RIPS\Connector\Requests\OAuth2;

use RIPS\Connector\Requests\BaseRequest;

class ClientRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param integer|null $clientId
     * @return string
     */
    private function uri($clientId = null)
    {
        return is_null($clientId) ? '/oauth/v2/clients' : "/oauth/v2/clients/{$clientId}";
    }

    /**
     * Get all clients
     *
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a client by id
     *
     * @param int $clientId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($clientId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($clientId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new client
     *
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['client' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a client by id
     *
     * @param int $clientId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($clientId, array $input, array $queryParams = [])
    {
        $response = $this->client->put($this->uri($clientId), [
            'form_params' => ['client' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete a client by id
     *
     * @param int $clientId
     * @param array $queryParams
     * @return void
     */
    public function delete($clientId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($clientId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
