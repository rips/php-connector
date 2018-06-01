<?php

namespace RIPS\Connector\Requests;

class MaintenanceRequests extends BaseRequest
{
    /**
     * Get status info for the current session and API env.
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
