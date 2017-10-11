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
     * @return stdClass[]
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
     * @return stdClass
     */
    public function getById($logId)
    {
        $response = $this->client->get($this->uri($logId));

        return $this->handleResponse($response);
    }

    /**
     * Create a new log
     *
     * @param array $input
     * @return stdClass
     */
    public function create(array $input)
    {
        $response = $this->client->post($this->uri(), [
            'form_params' => ['log' => $input],
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
        $this->client->delete($this->uri(), [
            'query' => $queryParams,
        ]);
    }
}
