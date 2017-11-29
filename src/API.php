<?php

namespace RIPS\Connector;

use GuzzleHttp\Client;
use RIPS\Connector\Requests\ApplicationRequests;
use RIPS\Connector\Requests\LicenseRequests;
use RIPS\Connector\Requests\LogRequests;
use RIPS\Connector\Requests\OrgRequests;
use RIPS\Connector\Requests\QuotaRequests;
use RIPS\Connector\Requests\SettingsRequests;
use RIPS\Connector\Requests\SourceRequests;
use RIPS\Connector\Requests\StatusRequests;
use RIPS\Connector\Requests\TeamRequests;
use RIPS\Connector\Requests\UserRequests;
use RIPS\Connector\Requests\ActivityRequests;

class API
{
    /**
     * @var string
     */
    protected $version = '2.9.0';

    /**
     * @var ApplicationRequests
     */
    public $applications;

    /**
     * @var LicenseRequests
     */
    public $licenses;

    /**
     * @var LogRequests
     */
    public $logs;

    /**
     * @var OrgRequests
     */
    public $orgs;

    /**
     * @var QuotaRequests
     */
    public $quotas;

    /**
     * @var SettingsRequests
     */
    public $settings;

    /**
     * @var SourceRequests
     */
    public $sources;

    /**
     * @var StatusRequests
     */
    public $status;

    /**
     * @var TeamRequests
     */
    public $teams;

    /**
     * @var UserRequests
     */
    public $users;

    /**
     * @var ActivityRequests
     */
    public $activities;

    /**
     * @var array - Config values for GuzzleClient
     */
    protected $clientConfig = [
        'base_uri' => 'http://localhost:8080',
        'timeout' => 100,
        'connect_timeout' => 10,
        'http_errors' => false,
    ];

    /**
     * Construct and optionally initialize new API
     * Initialization is only done if both username and password are specified.
     *
     * @param string $username
     * @param string $password
     * @param array $clientConfig
     */
    public function __construct($username = null, $password = null, array $clientConfig = [])
    {
        if ($username && $password) {
            $this->initialize($username, $password, $clientConfig);
        }
    }

    /**
     * Initialize new API
     * Separation from the constructor is required because in some cases the information are not yet known when
     * the object is constructed.
     *
     * @param string $username
     * @param string $password
     * @param array $clientConfig
     */
    public function initialize($username, $password, array $clientConfig = [])
    {
        $mergedConfig = array_merge($this->clientConfig, $clientConfig, [
            'headers' => [
                'X-API-Username' => $username,
                'X-API-Password' => $password,
                'User-Agent' => "RIPS-API-Connector/{$this->version}",
            ],
        ]);

        $client = new Client($mergedConfig);
        $this->applications = new ApplicationRequests($client);
        $this->licenses = new LicenseRequests($client);
        $this->logs = new LogRequests($client);
        $this->orgs = new OrgRequests($client);
        $this->quotas = new QuotaRequests($client);
        $this->settings = new SettingsRequests($client);
        $this->sources = new SourceRequests($client);
        $this->status = new StatusRequests($client);
        $this->teams = new TeamRequests($client);
        $this->users = new UserRequests($client);
        $this->activities = new ActivityRequests($client);
    }

    /**
     * Get the current version number
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}
