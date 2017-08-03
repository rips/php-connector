<?php

namespace RIPS\APIConnector\Requests;

class QuotaRequests extends BaseRequest
{
    // @var string
    protected $uri = '/quotas';

    public function create(array $input)
    {
        $response = $this->client->post($this->uri, [
            'form_params' => ['quota' => $input],
        ]);

        return json_decode($response->getBody());
    }
}
