<?php

namespace RIPS\Test\Requests;

use RIPS\Connector\Requests\System\EmailRequests;
use RIPS\Connector\Requests\System\HealthRequests;
use RIPS\Connector\Requests\System\LdapRequests;
use RIPS\Connector\Requests\SystemRequests;
use RIPS\Test\TestCase;

class SystemRequestsTest extends TestCase
{
    /** @var SystemRequests */
    protected $systemRequests;

    protected function setUp()
    {
        parent::setUp();

        $this->systemRequests = new SystemRequests($this->client);
    }

    /**
     * @test
     */
    public function ldap()
    {
        $ldapRequests = $this->systemRequests->ldap();

        $this->assertInstanceOf(LdapRequests::class, $ldapRequests);
    }

    /**
     * @test
     */
    public function health()
    {
        $healthRequests = $this->systemRequests->health();

        $this->assertInstanceOf(HealthRequests::class, $healthRequests);
    }

    /**
     * @test
     */
    public function email()
    {
        $emailRequests = $this->systemRequests->email();

        $this->assertInstanceOf(EmailRequests::class, $emailRequests);
    }
}
