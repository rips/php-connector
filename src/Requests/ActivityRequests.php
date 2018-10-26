<?php

namespace RIPS\Connector\Requests;

use RIPS\Connector\Entities\Response;

class ActivityRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $activityId
     * @return string
     */
    public function uri($activityId = null)
    {
        return is_null($activityId) ? '/activities' : "/activities/{$activityId}";
    }

    /**
     * Get all activities
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
     * Get a activity by id
     *
     * @param int $activityId
     * @param array $queryParams
     * @return Response
     */
    public function getById($activityId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($activityId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
