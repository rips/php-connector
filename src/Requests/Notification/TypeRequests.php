<?php

namespace RIPS\Connector\Requests\Notification;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class TypeRequests extends BaseRequest
{
    /**
     * Build a uri for the request.
     *
     * @return string
     */
    public function uri()
    {
        return '/notifications/types';
    }

    /**
     * Get all notification types.
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
