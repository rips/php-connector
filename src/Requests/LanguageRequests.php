<?php

namespace RIPS\Connector\Requests;

class LanguageRequests extends BaseRequest
{
    /**
     * Build a uri for the request
     *
     * @param int $languageId
     * @return string
     */
    public function uri($languageId = null)
    {
        return is_null($languageId) ? '/languages' : "/languages/{$languageId}";
    }

    /**
     * Get all languages
     *
     * @param array $queryParams
     * @return \stdClass[]
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get(
            $this->uri(),
            [
                'query' => $queryParams,
            ]
        );

        return $this->handleResponse($response);
    }

    /**
     * Get a language by language ID
     *
     * @param int $languageId
     * @param array $queryParams
     * @return \stdClass
     */
    public function getById($languageId, array $queryParams = [])
    {
        $response = $this->client->get(
            $this->uri($languageId),
            [
                'query' => $queryParams,
            ]
        );

        return $this->handleResponse($response);
    }
}
