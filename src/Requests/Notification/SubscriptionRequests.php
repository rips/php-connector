<?php

namespace RIPS\Connector\Requests\Notification;

use GuzzleHttp\RequestOptions;
use RIPS\Connector\Entities\Response;
use RIPS\Connector\Exceptions\LibException;
use RIPS\Connector\Requests\BaseRequest;

class SubscriptionRequests extends BaseRequest
{
    /**
     * Build a uri for the request.
     *
     * @param int $subscriptionId
     * @return string
     */
    public function uri($subscriptionId = null)
    {
        return is_null($subscriptionId) ? '/notifications/subscriptions' : "/notifications/subscriptions/{$subscriptionId}";
    }

    /**
     * Get all notification subscriptions.
     *
     * @param array $queryParams
     * @return Response
     */
    public function getAll(array $queryParams = [])
    {
        $response = $this->client->get($this->uri(), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Get a notification subscription by ID.
     *
     * @param int $subscriptionId
     * @param array $queryParams
     * @return Response
     */
    public function getById($subscriptionId, array $queryParams = [])
    {
        $response = $this->client->get($this->uri($subscriptionId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Create a new notification subscription.
     *
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function create(array $input, array $queryParams = [])
    {
        $response = $this->client->post($this->uri(), [
            RequestOptions::JSON => ['subscription' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Update a notification subscription by ID.
     *
     * @param int $subscriptionId
     * @param array $input
     * @param array $queryParams
     * @return Response
     */
    public function update($subscriptionId, $input, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($subscriptionId), [
            RequestOptions::JSON => ['subscription' => $input],
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Delete a notification subscription by ID.
     *
     * @param int $subscriptionId
     * @param array $queryParams
     * @return Response
     */
    public function deleteById($subscriptionId, array $queryParams = [])
    {
        if (is_null($subscriptionId)) {
            throw new LibException('subscriptionId is null');
        }

        $response = $this->client->delete($this->uri($subscriptionId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
