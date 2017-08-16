<?php

namespace RIPS\Connector;

use GuzzleHttp\Client;
use RIPS\Connector\Requests\UserRequests;
use RIPS\Connector\Requests\OrgRequests;
use RIPS\Connector\Requests\QuotaRequests;
use RIPS\Connector\Requests\ApplicationRequests;
use RIPS\Connector\Requests\ScanRequests;

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

    // @var ApplicationRequests
    public $applications;

    // @var ScanRequests
    public $scans;

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
        $this->applications = new ApplicationRequests($client);
        $this->scans = new ScanRequests($client);
    }
}
