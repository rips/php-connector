<?php

namespace RIPS\Connector\Requests;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\ClientException;

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
     * @return Response
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

        try {
            $body = $this->handleResponse($response)->getDecodedData();
        } catch (ClientException $exception) {
            return false;
        }

        return property_exists(
            $body,
            'user'
        );
    }
}
