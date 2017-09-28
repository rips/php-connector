<?php

namespace RIPS\Connector\Requests\Application\Scan\Export;

use RIPS\Connector\Requests\BaseRequest;

class PdfRequests extends BaseRequest
{
    /** @var string */
    protected $uri = '/applications';

    /**
     * Get a pdf report
     *
     * @param int $applicationId
     * @param int $scanId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($applicationId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri}/{$applicationId}/scans/{$scanId}/exports/pdfs", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response, true);
    }
}
