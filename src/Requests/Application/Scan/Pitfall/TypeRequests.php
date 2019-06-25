<?php

namespace RIPS\Connector\Requests\Application\Scan\Pitfall;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class TypeRequests extends BaseRequest
{
    /**
     * Build a URI for the request
     *
     * @param int $typeId
     * @return string
     */
    protected function uri($typeId = null)
    {
        return is_null($typeId)
            ? '/applications/scans/pitfalls/types'
            : "/applications/scans/pitfalls/types/{$typeId}";
    }

    /**
     * Get all types
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
     * Get type by id
     *
     * @param int $typeId
     * @param array $queryParams
     * @return Response
     */
    public function getById($typeId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($typeId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
