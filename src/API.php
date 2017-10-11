<?php

namespace RIPS\Connector;

use GuzzleHttp\Client;
use RIPS\Connector\Requests\ApplicationRequests;
use RIPS\Connector\Requests\LogRequests;
use RIPS\Connector\Requests\OrgRequests;
use RIPS\Connector\Requests\QuotaRequests;
use RIPS\Connector\Requests\TeamRequests;
use RIPS\Connector\Requests\UserRequests;
use RIPS\Connector\Requests\Application\CustomRequests;
use RIPS\Connector\Requests\Application\ScanRequests;
use RIPS\Connector\Requests\Application\UploadRequests;
use RIPS\Connector\Requests\Application\Scan\IssueRequests;
use RIPS\Connector\Requests\Application\Scan\Export\PdfRequests;

class API
{
    /**
     * @var string
     */
    public $version = '1.2.0';

    /**
     * @var ApplicationRequests
     */
    public $applications;

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
     * @var TeamRequests
     */
    public $teams;

    /**
     * @var UserRequests
     */
    public $users;

    /**
     * @var CustomRequests
     */
    public $customs;

    /**
     * @var ScanRequests
     */
    public $scans;

    /**
     * @var UploadRequests
     */
    public $uploads;

    /**
     * @var IssueRequests
     */
    public $issues;

    /**
     * @var PdfRequests
     */
    public $pdfs;

    /** @var array $clientConfig Config values for $client */
    protected $clientConfig = [
        'base_uri' => 'http://localhost:8000',
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
        $this->logs = new LogRequests($client);
        $this->orgs = new OrgRequests($client);
        $this->quotas = new QuotaRequests($client);
        $this->teams = new TeamRequests($client);
        $this->users = new UserRequests($client);
        $this->scans = new ScanRequests($client);
        $this->uploads = new UploadRequests($client);
        $this->issues = new IssueRequests($client);
        $this->pdfs = new PdfRequests($client);
    }
}
