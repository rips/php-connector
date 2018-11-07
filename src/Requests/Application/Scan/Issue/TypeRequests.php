<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;
use RIPS\Connector\Requests\Application\Scan\Issue\Type\PatchRequests;

class TypeRequests extends BaseRequest
{
    /**
     * @var PatchRequests
     */
    protected $patchRequests;

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

    /**
     * Patch requests accessor
     *
     * @return PatchRequests
     */
    public function patches()
    {
        if (is_null($this->patchRequests)) {
            $this->patchRequests = new PatchRequests($this->client);
        }

        return $this->patchRequests;
    }
}
