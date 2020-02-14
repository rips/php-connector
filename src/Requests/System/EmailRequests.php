<?php

namespace RIPS\Connector\Requests\System;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class EmailRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @return string
     */
    protected function uri()
    {
        return "/systems/emails";
    }

    /**
     * Get e-mail settings
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
     * Update e-mail settings
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update(array $input, array $queryParams = [])
    {
        $response = $this->client->put("{$this->uri()}", [
            RequestOptions::JSON => ['email' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Send a test email
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function test(array $input, array $queryParams = [])
    {
        $response = $this->client->post("{$this->uri()}/tests", [
            RequestOptions::JSON => ['test' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
