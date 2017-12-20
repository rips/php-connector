<?php

namespace RIPS\Connector\Requests;

use RIPS\Connector\Requests\OAuth2\AccessTokenRequest;
use RIPS\Connector\Requests\OAuth2\ClientRequests;

class OAuth2Requests extends BaseRequest
{
    /**
     * @var AccessTokenRequest
     */
    public $accessTokenRequests;

    /**
     * @var ClientRequests
     */
    public $clientRequests;

    /**
     * Client request accessor
     *
     * @return ClientRequests
     */
    public function clients()
    {
        if (is_null($this->clientRequests)) {
            $this->clientRequests = new ClientRequests($this->client);
        }

        return $this->clientRequests;
    }

    /**
     * Access token request accessor
     *
     * @return AccessTokenRequest
     */
    public function accessTokens()
    {
        if (is_null($this->accessTokenRequests)) {
            $this->accessTokenRequests = new AccessTokenRequest($this->client);
        }

        return $this->accessTokenRequests;
    }
}
