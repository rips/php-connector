<?php

namespace RIPS\Connector\Requests\System;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class HealthRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @return string
     */
    protected function uri()
    {
        return "/systems/health";
    }

    /**
     * Get system health modules states
     *
     * @return Response
     */
    public function get()
    {
        $response = $this->client->get("{$this->uri()}");

        return $this->handleResponse($response);
    }
}
