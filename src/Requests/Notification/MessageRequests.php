<?php

namespace RIPS\Connector\Requests\Notification;

use RIPS\Connector\Entities\Response;
use RIPS\Connector\Requests\BaseRequest;

class MessageRequests extends BaseRequest
{
    /**
     * Build a uri for the request.
     *
     * @param int $messageId
     * @return string
     */
    public function uri($messageId = null)
    {
        return is_null($messageId) ? '/notifications/messages' : "/notifications/messages/{$messageId}";
    }

    /**
     * Get all notification messages.
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
     * Update a notification message by ID (mark as read).
     *
     * @param int $subscriptionId
     * @param array $queryParams
     * @return Response
     */
    public function markAsRead($subscriptionId, array $queryParams = [])
    {
        $response = $this->client->patch($this->uri($subscriptionId), [
            'query' => $queryParams,
        ]);

        return $this->handleResponse($response);
    }
}
