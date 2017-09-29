<?php

namespace RIPS\Connector\Requests\Application;

use RIPS\Connector\Requests\BaseRequest;

class ScanRequests extends BaseRequest
{
    /**
     * Build the uri for the request
     *
     * @param int $appId
     * @return string
     */
    protected function uri($appId)
    {
        return "/applications/{$appId}/scans";
    }

    /**
     * Get all scans, optionally by application ID
     *
     * @param int|null $appId
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll($appId = null, array $queryParams = [])
    {
        $path = $appId ? $this->uri($appId) : '/applications/scans/all';
        $response = $this->client->get($path, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a scan by application ID and scan ID
     *
     * @param int $appId
     * @param int $scanId
     * @return \stdClass
     */
    public function getById($appId, $scanId)
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}");

        return $this->handleResponse($response);
    }

    /**
     * Get scan statistics for a single scan
     *
     * @param int $appId
     * @param int $scanId
     * @return \stdClass
     */
    public function getStats($appId, $scanId)
    {
        $response = $this->client->get("{$this->uri($appId)}/stats", [
            'query' => ['equal[id]' => $scanId],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get classes for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getClasses($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/classes", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a class for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $classId
     * @return stdClass
     */
    public function getClassById($appId, $scanId, $classId)
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/classes/{$classId}");

        return $this->handleResponse($response);
    }

    /**
     * Get comparison for scan
     *
     * @param int $appId
     * @param int $scanId
     * @return stdClass
     */
    public function getComparison($appId, $scanId)
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/comparison");

        return $this->handleResponse($response);
    }

    /**
     * Get all concats for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getConcats($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/concats", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a concat for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $concatId
     * @return stdClass
     */
    public function getConcatById($appId, $scanId, $concatId)
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/concats/{$concatId}");

        return $this->handleResponse($response);
    }

    /**
     * Get all files for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getFiles($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/files", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a file for a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $fileId
     * @return stdClass
     */
    public function getFileById($appId, $scanId, $fileId)
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/files/{$fileId}");

        return $this->handleResponse($response);
    }

    /**
     * Get functions for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return stdClass[]
     */
    public function getFunctions($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/functions", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get function for scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param int $functionId
     * @return stdClass
     */
    public function getFunctionById($appId, $scanId, $functionId)
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}/functions/{$functionId}");

        return $this->handleResponse($response);
    }

    /**
     * Create a function for a scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @return stdClass
     */
    public function createFunction($appId, $scanId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId)}/{$scanId}/functions/batches", [
            'form_params' => ['function' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create class for scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @return stdClass
     */
    public function createClass($appId, $scanId, array $input = [])
    {
        $response = $this->client->post("{$this->uri($appId)}/{$scanId}/classes/batches", [
            'form_params' => ['class' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete all scans
     *
     * @param int $appId
     * @param array $queryParams
     * @return void
     */
    public function deleteAll($appId, array $queryParams = [])
    {
        $response = $this->client->delete($this->uri($appId), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response);
    }

    /**
     * Delete the source code of scan
     *
     * @param int $appId
     * @param int $scanId
     * @return stdClass
     */
    public function deleteFiles($appId, $scanId)
    {
        $this->client->delete("{$this->uri($appId)}/{$scanId}/files");
    }

    /**
     * Delete a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @return void
     */
    public function deleteById($appId, $scanId)
    {
        $response = $this->client->delete("{$this->uri($appId)}/{$scanId}");

        $this->handleResponse($response);
    }

    /**
     * Update an existing scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @return \stdClass
     */
    public function update($appId, $scanId, array $input)
    {
        $response = $this->client->patch("{$this->uri($appId)}/{$scanId}", [
            'form_params' => ['scan' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Start a new scan
     *
     * @param int $appId
     * @param array $input
     * @return \stdClass
     */
    public function create($appId, array $input)
    {
        $response = $this->client->post("{$this->uri($appId)}", [
            'form_params' => ['scan' => $input],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Block until scan is finished
     *
     * @param int $appId
     * @param int $scanId
     * @param int $waitTime - Optional time to wait, will wait indefinitely if 0 (default: 0)
     * @param int $sleepTime - Time to wait between scan completion checks (default: 5)
     * @return void
     * @throws \Exception if scan does not finish in time
     */
    public function blockUntilDone(
        $appId,
        $scanId,
        $waitTime = 0,
        $sleepTime = 5
    ) {
        for ($iteration = 0;; $iteration++) {
            $scan = $this->getById($appId, $scanId);

            if ((int) $scan->phase === 0 && (int) $scan->percent === 100) {
                break;
            } else if ($waitTime > 0 && $iteration > ($waitTime / $sleepTime)) {
                throw new \Exception('Scan did not finish before the defined wait time.');
            }

            sleep($sleepTime);
        }
    }
}
