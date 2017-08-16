<?php

namespace RIPS\Connector\Requests\Application;

use RIPS\Connector\Requests\BaseRequest;

class ScanRequests extends BaseRequest
{
    // @var string
    protected $uri = '/applications';

    /**
     * Get all scans (independent of the application)
     *
     * @param array $queryParams
     * @return array
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri}/scans/all", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a scan by application ID and scan ID
     *
     * @param int $applicationId
     * @param int $scanId
     * @return array
     */
    public function getById(int $applicationId, int $scanId)
    {
        $response = $this->client->get("{$this->uri}/{$applicationId}/scans/{$scanId}");

        return $this->handleResponse($response);
    }

    /**
     * Get scan statistics for a single scan
     *
     * @param int $applicationId
     * @param int $scanId
     * @return array
     */
    public function getStatsById(int $applicationId, int $scanId)
    {
        $response = $this->client->get("{$this->uri}/{$applicationId}/scans/stats", [
            'query' => ['equal[id]' => $scanId],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Start a new scan
     *
     * @param int $applicationId
     * @param array $input
     * @return array
     */
    public function scan(int $applicationId, array $input)
    {
        $response = $this->client->post("{$this->uri}/{$applicationId}/scans", [
            'form_params' => ['scan' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
