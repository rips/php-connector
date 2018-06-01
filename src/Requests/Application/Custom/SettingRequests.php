<?php

namespace RIPS\Connector\Requests\Application\Custom;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Requests\BaseRequest;

class SettingRequests extends BaseRequest
{
    /**
     * Build the URI for the requests
     *
     * @param int $appId
     * @param int $customId
     * @return string
     */
    protected function uri($appId, $customId)
    {
        return "/applications/{$appId}/customs/{$customId}/settings";
    }

    /**
     * Get settings for custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $queryParams
     * @return \stdClass
     */
    public function get($appId, $customId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($appId, $customId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create or update settings for a custom profile
     *
     * @param int $appId
     * @param int $customId
     * @param array $input
     * @param array $queryParams
     * @return \stdClass
     */
    public function update($appId, $customId, array $input, array $queryParams = [])
    {
        $response = $this->client->put($this->uri($appId, $customId), [
            RequestOptions::JSON => ['setting' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
