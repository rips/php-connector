<?php

namespace RIPS\Connector\Requests\OAuth2;

use RIPS\Connector\Requests\BaseRequest;

class AccessTokenRequest extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @return string
     */
    protected function uri()
    {
        return '/oauth/v2/auth/tokens';
    }

    /**
     * Get status info for the current session and API env.
     *
     * @return \stdClass
     */
    public function getTokens()
    {
        $response = $this->client->post($this->uri());

        return $this->handleResponse($response);
    }
}
