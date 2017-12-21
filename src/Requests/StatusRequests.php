<?php

namespace RIPS\Connector\Requests;

class StatusRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @return string
     */
    protected function uri()
    {
        return '/status';
    }

    /**
     * Get status info for the current session and API env.
     *
     * @param array $queryParams
     * @return \stdClass
     */
    public function getStatus(array $queryParams = [])
    {
        $response = $this->client->get($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Checks if the user is logged with the given credentials
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        $response = $this->client->get($this->uri());

        $body = $this->handleResponse($response);

        return property_exists(
            $body,
            'user'
        );
    }
}
