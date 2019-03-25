<?php

namespace RIPS\Connector\Requests;

class SystemRequests extends BaseRequest
{
    /**
     * @var System\LdapRequests
     */
    protected $ldapRequests;

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
}
