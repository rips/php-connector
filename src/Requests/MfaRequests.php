<?php

namespace RIPS\Connector\Requests;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;

class MfaRequests extends BaseRequest
{
    const URL_SECRET = '/mfas/secret';
    const URL_TOKEN  = '/mfas/token';
    const URL_DELETE = '/mfas/delete';

    /**
     * Get the secret
     *
     * @param array $queryParams
     * @return Response
     */
    public function getSecret(array $queryParams = [])
    {
        $response = $this->client->post(self::URL_SECRET, [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get the token
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function getToken(array $input, array $queryParams = [])
    {
        $response = $this->client->post(self::URL_TOKEN, [
            RequestOptions::JSON => ['challenge' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Disable MFA for own user
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function delete(array $input, array $queryParams = [])
    {
        $response = $this->client->post(self::URL_DELETE, [
            RequestOptions::JSON => ['challenge' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
