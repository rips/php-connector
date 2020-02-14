<?php

namespace RIPS\Connector\Requests\Application\Scan;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class ExportRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @param int $scanId
     * @param string $type
     * @return string
     */
    protected function uri($appId, $scanId, $type)
    {
        return "/applications/{$appId}/scans/{$scanId}/exports/{$type}";
    }

    /**
     * Export info for scan in CSV format
     *
     * @param int $appId
     * @param int $scanId
     * @param string $outFile - File path that CSV contents will be stored to
     * @param array $queryParams
     * @return Response
     */
    public function exportCsv($appId, $scanId, $outFile, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, 'csvs'), [
            'sink'  => $outFile,
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Export info for scan in PDF format
     *
     * @param int $appId
     * @param int $scanId
     * @param string $outFile - File path that PDF contents will be stored to
     * @param array $queryParams
     * @return Response
     */
    public function exportPdf($appId, $scanId, $outFile, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, 'pdfs'), [
            'sink'  => $outFile,
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new pdf export on the queue
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return Response
     */
    public function queuePdf($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->post($this->uri($appId, $scanId, 'pdfs') . '/queues', [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get information about pdf export on queue
     *
     * @param $appId
     * @param $scanId
     * @param $queueId
     * @param array $queryParams
     * @return Response
     */
    public function getQueuedPdf($appId, $scanId, $queueId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, 'pdfs') . '/queues/' . $queueId, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Remove a pdf export from the queue
     *
     * @param $appId
     * @param $scanId
     * @param $queueId
     * @param array $queryParams
     * @return Response
     */
    public function deleteQueuedPdf($appId, $scanId, $queueId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId, $scanId, 'pdfs') . '/queues/' . $queueId, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Download pdf export from queue
     *
     * @param $appId
     * @param $scanId
     * @param $queueId
     * @param $outFile
     * @param array $queryParams
     * @return Response
     */
    public function downloadQueuedPdf($appId, $scanId, $queueId, $outFile, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, 'pdfs') . '/queues/' . $queueId . '/downloads', [
            'sink'  => $outFile,
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get information about all pdf exports on queue
     *
     * @param $appId
     * @param $scanId
     * @param array $queryParams
     * @return Response
     */
    public function getAllQueuedPdf($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $scanId, 'pdfs') . '/queues', [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
