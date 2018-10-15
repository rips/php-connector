<?php

namespace RIPS\Connector\Requests\Application\Scan\Issue;

use RIPS\Connector\Requests\Application\Scan\Issue\Source\TypeRequests;
use RIPS\Connector\Requests\BaseRequest;

class SourceRequests extends BaseRequest
{
    /**
     * @var TypeRequests
     */
    protected $typeRequests;

    /**
     * Type requests accessor
     *
     * @return TypeRequests
     */
    public function types()
    {
        if (is_null($this->typeRequests)) {
            $this->typeRequests = new TypeRequests($this->client);
        }

        return $this->typeRequests;
    }
}
