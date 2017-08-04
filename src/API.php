<?php

namespace RIPS\APIConnector;

use GuzzleHttp\Client;
use RIPS\APIConnector\Requests\UserRequests;
use RIPS\APIConnector\Requests\OrgRequests;
use RIPS\APIConnector\Requests\QuotaRequests;

class API
{
    // @var string - version number
    public $version = '0.0.1';

    // @var UserRequests
    public $users;

    // @var OrgRequests
    public $orgs;

    // @var QuotaRequests
    public $quotas;

    // @var array - Config values for $client
    protected $clientConfig = [
        'base_uri' => 'http://localhost:8000',
        'timeout' => 10,
        'connect_timeout' => 10,
        'http_errors' => false,
    ];

    /**
     * Initialize new API
     *
     * @param string $username
     * @param string $password
     * @param array $clientConfig
     */
    public function __construct(string $username, string $password, array $clientConfig = [])
    {
        $mergedConfig = array_merge($this->clientConfig, $clientConfig, [
            'headers' => [
                'X-API-Username' => $username,
                'X-API-Password' => $password,
                'User-Agent' => "RIPS-API-Connector/{$this->version}",
            ],
        ]);

        $client = new Client($mergedConfig);
        $this->users = new UserRequests($client);
        $this->orgs = new OrgRequests($client);
        $this->quotas = new QuotaRequests($client);
    }
}
