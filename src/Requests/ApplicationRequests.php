<?php

namespace RIPS\Connector\Requests;

class ApplicationRequests extends BaseRequest
{
    // @var string
    protected $uri = '/applications';

    /**
     * Get all applications
     *
     * @param array $queryParams
     * @return array
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
