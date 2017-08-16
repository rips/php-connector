<?php

namespace RIPS\Connector\Requests;

class QuotaRequests extends BaseRequest
{
    /** @var string */
    protected $uri = '/quotas';

    /**
     * Create a new quota
     *
     * @param array $input
     * @return array
     */
    public function create(array $input)
    {
        $response = $this->client->post($this->uri, [
            'form_params' => ['quota' => $input],
        ]);

        return $this->handleResponse($response);
    }
}
