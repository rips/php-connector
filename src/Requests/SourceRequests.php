<?php

namespace RIPS\Connector\Requests;

use RIPS\Connector\Entities\Response;

class SourceRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @return string
     */
    protected function uri()
    {
        return '/sources';
    }

    /**
     * Get all directories from the root source directory
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
}
