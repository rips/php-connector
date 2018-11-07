<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue\Type;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class PatchRequests extends BaseRequest
{
    /**
     * Build a URI for the request
     *
     * @param int $patchId
     * @return string
     */
    protected function uri($patchId = null)
    {
        return is_null($patchId)
            ? '/applications/scans/issues/types/patches'
            : "/applications/scans/issues/types/patches/{$patchId}";
    }

    /**
     * Get all patches
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
     * Get patch by id
     *
     * @param int $patchId
     * @param array $queryParams
     * @return Response
     */
    public function getById($patchId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($patchId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
