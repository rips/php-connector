<?php

namespace RIPS\Connector\Requests\OAuth2;

use RIPS\Connector\Requests\BaseRequest;

class LoginCheckRequest extends BaseRequest
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
