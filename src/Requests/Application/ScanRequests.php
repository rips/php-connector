<?php

namespace RIPS\Connector\Requests\Application;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Requests\Application\Scan\ClassRequests;
use RIPS\Connector\Requests\Application\Scan\ComparisonRequests;
use RIPS\Connector\Requests\Application\Scan\ConcatRequests;
use RIPS\Connector\Requests\Application\Scan\ExportRequests;
use RIPS\Connector\Requests\Application\Scan\FileRequests;
use RIPS\Connector\Requests\Application\Scan\FunctionRequests;
use RIPS\Connector\Requests\Application\Scan\IssueRequests;
use RIPS\Connector\Requests\Application\Scan\ProcessRequests;
use RIPS\Connector\Requests\Application\Scan\SinkRequests;
use RIPS\Connector\Requests\Application\Scan\SourceRequests;
use RIPS\Connector\Requests\Application\Scan\EntrypointRequests;
use RIPS\Connector\Requests\Application\Scan\LibraryRequests;
use RIPS\Connector\Requests\BaseRequest;

class ScanRequests extends BaseRequest
{
    /**
     * @var ClassRequests
     */
    protected $classRequests;

    /**
     * @var ComparisonRequests
     */
    protected $comparisonRequests;

    /**
     * @var ConcatRequests
     */
    protected $concatRequests;

    /**
     * @var ExportRequests
     */
    protected $exportRequests;

    /**
     * @var FileRequests
     */
    protected $fileRequests;

    /**
     * @var FunctionRequests
     */
    protected $functionRequests;

    /**
     * @var IssueRequests
     */
    protected $issueRequests;

    /**
     * @var ProcessRequests
     */
    protected $processRequests;

    /**
     * @var SinkRequests
     */
    protected $sinkRequests;

    /**
     * @var SourceRequests
     */
    protected $sourceRequests;

    /**
     * @var EntrypointRequests
     */
    protected $entrypointRequests;

    /**
     * @var LibraryRequests
     */
    protected $libraryRequests;

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
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->get("{$this->uri($appId)}/{$scanId}", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get scan statistics for a single scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getStats($appId, $scanId, array $queryParams = [])
    {
        $queryParams['equal[id]'] = $scanId;

        $response = $this->client->get("{$this->uri($appId)}/stats", [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Start a new scan
     *
     * @param int $appId
     * @param array $input
     * @param array $queryParams
     * @param boolean $defaultInput
     * @return \stdClass
     */
    public function create($appId, array $input, array $queryParams = [], $defaultInput = true)
    {
        if ($defaultInput) {
            $params = ['scan' => $input];
        } else {
            $params = $input;
        }

        $response = $this->client->post("{$this->uri($appId)}", [
            RequestOptions::JSON => $params,
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update an existing scan
     *
     * @param int $appId
     * @param int $scanId
     * @param array $input
     * @param array $queryParams
     * @param boolean $defaultInput
     * @return \stdClass
     */
    public function update($appId, $scanId, array $input, array $queryParams = [], $defaultInput = true)
    {
        if ($defaultInput) {
            $params = ['scan' => $input];
        } else {
            $params = $input;
        }

        $response = $this->client->patch("{$this->uri($appId)}/{$scanId}", [
            RequestOptions::JSON => $params,
            'query' => $queryParams,
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

        $this->handleResponse($response, true);
    }

    /**
     * Delete a scan by id
     *
     * @param int $appId
     * @param int $scanId
     * @param array $queryParams
     * @return void
     */
    public function deleteById($appId, $scanId, array $queryParams = [])
    {
        $response = $this->client->delete("{$this->uri($appId)}/{$scanId}", [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }

    /**
     * Block until scan is finished
     *
     * @param int $appId
     * @param int $scanId
     * @param int $waitTime - Optional time to wait, will wait indefinitely if 0 (default: 0)
     * @param int $sleepTime - Time to wait between scan completion checks (default: 5)
     * @param array $queryParams
     * @return \stdClass
     * @throws \Exception if scan does not finish in time
     */
    public function blockUntilDone(
        $appId,
        $scanId,
        $waitTime = 0,
        $sleepTime = 5,
        array $queryParams = []
    ) {
        for ($iteration = 0;; $iteration++) {
            $scan = $this->getById($appId, $scanId, $queryParams);

            if ((int) $scan->phase === 0 && (int) $scan->percent === 100) {
                return $scan;
            } else if ($waitTime > 0 && $iteration > ($waitTime / $sleepTime)) {
                throw new \Exception('Scan did not finish before the defined wait time.');
            }

            sleep($sleepTime);
        }

        throw new \Exception('blockUntilDone unexpected state');
    }

    /**
     * Class requests accessor
     *
     * @return ClassRequests
     */
    public function classes()
    {
        if (is_null($this->classRequests)) {
            $this->classRequests = new ClassRequests($this->client);
        }

        return $this->classRequests;
    }

    /**
     * Comparison requests accessor
     *
     * @return ComparisonRequests
     */
    public function comparisons()
    {
        if (is_null($this->comparisonRequests)) {
            $this->comparisonRequests = new ComparisonRequests($this->client);
        }

        return $this->comparisonRequests;
    }

    /**
     * Concat requests accessor
     *
     * @return ConcatRequests
     */
    public function concats()
    {
        if (is_null($this->concatRequests)) {
            $this->concatRequests = new ConcatRequests($this->client);
        }

        return $this->concatRequests;
    }

    /**
     * Export requests accessor
     *
     * @return ExportRequests
     */
    public function exports()
    {
        if (is_null($this->exportRequests)) {
            $this->exportRequests = new ExportRequests($this->client);
        }

        return $this->exportRequests;
    }

    /**
     * File requests accessor
     *
     * @return FileRequests
     */
    public function files()
    {
        if (is_null($this->fileRequests)) {
            $this->fileRequests = new FileRequests($this->client);
        }

        return $this->fileRequests;
    }

    /**
     * Function requests accessor
     *
     * @return FunctionRequests
     */
    public function functions()
    {
        if (is_null($this->functionRequests)) {
            $this->functionRequests = new FunctionRequests($this->client);
        }

        return $this->functionRequests;
    }

    /**
     * Issue requests accessor
     *
     * @return IssueRequests
     */
    public function issues()
    {
        if (is_null($this->issueRequests)) {
            $this->issueRequests = new IssueRequests($this->client);
        }

        return $this->issueRequests;
    }

    /**
     * Process requests accessor
     *
     * @return ProcessRequests
     */
    public function processes()
    {
        if (is_null($this->processRequests)) {
            $this->processRequests = new ProcessRequests($this->client);
        }

        return $this->processRequests;
    }

    /**
     * Sink requests accessor
     *
     * @return SinkRequests
     */
    public function sinks()
    {
        if (is_null($this->sinkRequests)) {
            $this->sinkRequests = new SinkRequests($this->client);
        }

        return $this->sinkRequests;
    }

    /**
     * Source requests accessor
     *
     * @return SourceRequests
     */
    public function sources()
    {
        if (is_null($this->sourceRequests)) {
            $this->sourceRequests = new SourceRequests($this->client);
        }

        return $this->sourceRequests;
    }

    /**
     * Entrypoint requests accessor
     *
     * @return EntrypointRequests
     */
    public function entrypoints()
    {
        if (is_null($this->entrypointRequests)) {
            $this->entrypointRequests = new EntrypointRequests($this->client);
        }

        return $this->entrypointRequests;
    }

    /**
     * Libraries requests accessor
     *
     * @return LibraryRequests
     */
    public function libraries()
    {
        if (is_null($this->libraryRequests)) {
            $this->libraryRequests = new LibraryRequests($this->client);
        }

        return $this->libraryRequests;
    }
}
