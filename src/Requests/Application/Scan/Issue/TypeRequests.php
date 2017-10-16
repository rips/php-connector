<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

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
            ? '/applications/scans/issues/types'
            : "/applications/scans/issues/types/{$typeId}";
    }

    /**
     * Get all types
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
     * Get type by id
     *
     * @param int $typeId
     * @return \stdClass
     */
    public function getById($typeId)
    {
        $response = $this->client->get($this->uri($typeId));

        return $this->handleResponse($response);
    }
}
