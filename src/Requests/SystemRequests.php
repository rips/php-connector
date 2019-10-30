<?php

namespace RIPS\Connector\Requests;

use RIPS\Connector\Requests\System\EmailRequests;

class SystemRequests extends BaseRequest
{
    /**
     * @var System\LdapRequests
     */
    protected $ldapRequests;

    /**
     * @var System\HealthRequests
     */
    protected $healthRequests;

    /**
     * @var EmailRequests
     */
    protected $emailRequests;

    /**
     * LDAP requests accessor
     *
     * @return System\LdapRequests
     */
    public function ldap()
    {
        if (is_null($this->ldapRequests)) {
            $this->ldapRequests = new System\LdapRequests($this->client);
        }

        return $this->ldapRequests;
    }

    /**
     * Health requests accessor
     *
     * @return System\HealthRequests
     */
    public function health()
    {
        if (is_null($this->healthRequests)) {
            $this->healthRequests = new System\HealthRequests(($this->client));
        }

        return $this->healthRequests;
    }

    /**
     * Email requests accessor
     *
     * @return System\EmailRequests
     */
    public function email()
    {
        if (is_null($this->emailRequests)) {
            $this->emailRequests = new System\EmailRequests($this->client);
        }

        return $this->emailRequests;
    }
}
