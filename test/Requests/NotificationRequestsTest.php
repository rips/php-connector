<?php

namespace RIPS\Test\Requests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use RIPS\Connector\Requests\Application\AclRequests;
use RIPS\Connector\Requests\Notification\MessageRequests;
use RIPS\Connector\Requests\Notification\SubscriptionRequests;
use RIPS\Connector\Requests\Notification\TypeRequests;
use RIPS\Connector\Requests\NotificationRequests;
use RIPS\Test\TestCase;

class NotificationRequestsTest extends TestCase
{
    /** @var NotificationRequests */
    protected $notificationRequests;

    protected function setUp()
    {
        parent::setUp();

        $history = Middleware::history($this->container);

        $this->stack->push($history);
        $this->stack->setHandler(new MockHandler([
            new Response(200, ['x-header' => 'header-content'], '{"key": "value"}'),
        ]));

        $this->notificationRequests = new NotificationRequests($this->client);
    }

    /**
     * @test
     */
    public function types()
    {
        $typeRequests = $this->notificationRequests->types();

        $this->assertInstanceOf(TypeRequests::class, $typeRequests);
    }

    /**
     * @test
     */
    public function subscriptions()
    {
        $subscriptionRequests = $this->notificationRequests->subscriptions();

        $this->assertInstanceOf(SubscriptionRequests::class, $subscriptionRequests);
    }

    /**
     * @test
     */
    public function messages()
    {
        $messageRequests = $this->notificationRequests->messages();

        $this->assertInstanceOf(MessageRequests::class, $messageRequests);
    }
}
