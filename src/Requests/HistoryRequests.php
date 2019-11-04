<?php

namespace RIPS\Connector\Requests;

use RIPS\Connector\Requests\History\ScanRequests;

class HistoryRequests extends BaseRequest
{
    /**
     * @var ScanRequests
     */
    protected $scanRequests;

    public function scans()
    {
        if (is_null($this->scanRequests)) {
            $this->scanRequests = new ScanRequests($this->client);
        }

        return $this->scanRequests;
    }
}
