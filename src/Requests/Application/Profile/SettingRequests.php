<?php

namespace RIPS\Connector\Requests\Application\Profile;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class SettingRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $profileId
     * @return string
     */
    protected function uri($appId, $profileId)
    {
        return "/applications/{$appId}/profiles/{$profileId}/settings";
    }

    /**
     * Get settings for profile profile
     *
     * @param int $appId
     * @param int $profileId
     * @param array $queryParams
     * @return Response
     */
    public function get($appId, $profileId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $profileId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create or update settings for a profile profile
     *
     * @param int $appId
     * @param int $profileId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($appId, $profileId, array $input, array $queryParams = [])
    {
        $response = $this->client->put($this->uri($appId, $profileId), [
            RequestOptions::JSON => ['setting' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
