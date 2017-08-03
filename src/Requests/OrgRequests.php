<?php

namespace RIPS\APIConnector\Requests;

class OrgRequests extends BaseRequest
{
    // @var string
    protected $uri = '/organisations';

    public function getById(int $orgId)
    {
        $response = $this->client->get("{$this->uri}/$orgId");

        return json_decode($response->getBody(), true);
    }

    public function update(int $orgId, array $input)
    {
        $response = $this->client->patch("{$this->uri}/$orgId", [
            'form_params' => ['organisation' => $input],
        ]);

        return json_decode($response->getBody());
    }

    public function create(array $input)
    {
        $response = $this->client->post($this->uri, [
            'form_params' => ['organisation' => $input],
        ]);

        return json_decode($response->getBody());
    }
}
