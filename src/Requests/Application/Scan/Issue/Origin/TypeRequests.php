<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue\Origin;

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
            ? '/applications/scans/issues/origins/types'
            : "/applications/scans/issues/origins/types/{$typeId}";
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
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($typeId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($typeId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
