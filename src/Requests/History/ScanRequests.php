<?php

namespace RIPS\Connector\Requests\History;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class ScanRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $historyScanId
     * @return string
     */
    public function uri($historyScanId = null)
    {
        return is_null($historyScanId) ? '/histories/scans' : "/histories/scans/{$historyScanId}";
    }

    /**
     * Get history scan statistics
     *
     * @param array $queryParams
     * @return Response
     */
    public function getStats(array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri()}/stats", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get all history scans
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
     * Get a history scan by id
     *
     * @param int $historyScanId
     * @param array $queryParams
     * @return Response
     */
    public function getById($historyScanId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($historyScanId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
