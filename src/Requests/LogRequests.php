<?php

namespace RIPS\Connector\Requests;

class LogRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int|null $logId
     * @return string
     */
    private function uri($logId = null)
    {
        return is_null($logId) ? '/logs' : "/logs/{$logId}";
    }

    /**
     * Get all logs
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
     * Get a log by id
     *
     * @param int $logId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($logId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($logId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new log
     *
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['log' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete logs older than a week
     *
     * @param array $queryParams
     * @return void
     */
    public function delete(array $queryParams = [])
    {
        $response = $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);

        $this->handleResponse($response, true);
    }
}
