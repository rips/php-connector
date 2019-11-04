<?php

namespace RIPS\Connector\Requests;

use RIPS\Connector\Requests\Notification\MessageRequests;
use RIPS\Connector\Requests\Notification\SubscriptionRequests;
use RIPS\Connector\Requests\Notification\TypeRequests;

class NotificationRequests extends BaseRequest
{
    /**
     * @var TypeRequests
     */
    protected $typeRequests;

    /**
     * @var SubscriptionRequests
     */
    protected $subscriptionRequests;

    /**
     * @var MessageRequests
     */
    protected $messageRequests;

    /**
     * Types request accessor.
     *
     * @return TypeRequests
     */
    public function types()
    {
        if (is_null($this->typeRequests)) {
            $this->typeRequests = new TypeRequests($this->client);
        }

        return $this->typeRequests;
    }

    /**
     * Subscriptions request accessor.
     *
     * @return SubscriptionRequests
     */
    public function subscriptions()
    {
        if (is_null($this->subscriptionRequests)) {
            $this->subscriptionRequests = new SubscriptionRequests($this->client);
        }

        return $this->subscriptionRequests;
    }

    /**
     * Messages request accessor.
     *
     * @return MessageRequests
     */
    public function messages()
    {
        if (is_null($this->messageRequests)) {
            $this->messageRequests = new MessageRequests($this->client);
        }

        return $this->messageRequests;
    }
}
