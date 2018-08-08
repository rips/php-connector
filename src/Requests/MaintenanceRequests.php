<?php

namespace RIPS\Connector\Requests;

class MaintenanceRequests extends BaseRequest
{
    /**
     * Remove old and unused code from cloud.
     *
     * @param array $queryParams
     * @return \stdClass
     */
    public function deleteCode(array $queryParams = [])
    {
        $response = $this->client->delete('/maintenance/code', [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
