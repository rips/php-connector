<?php

namespace RIPS\Connector\Requests\System;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class LdapRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @return string
     */
    protected function uri()
    {
        return "/systems/ldap";
    }

    /**
     * Get a scan by application ID and scan ID
     *
     * @param array $queryParams
     * @return Response
     */
    public function get(array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri()}", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing scan
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update(array $input, array $queryParams = [])
    {
        $response = $this->client->put("{$this->uri()}", [
            RequestOptions::JSON => ['ldap' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Force LDAP synchronization
     *
     * @param array $queryParams
     * @return Response
     */
    public function sync(array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri()}/sync", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
