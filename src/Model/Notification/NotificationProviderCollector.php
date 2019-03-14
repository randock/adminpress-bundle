<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Notification;

use Countable;

class NotificationProviderCollector implements Countable
{
    /**
     * @var NotificationProviderInterface[]
     */
    protected $notificationProviders;

    public function __construct()
    {
        $this->notificationProviders = [];
    }

    public function addNotificationProvider(NotificationProviderInterface $notificationProvider)
    {
        $this->notificationProviders[] = $notificationProvider;
    }

    public function count()
    {
        return \count($this->notificationProviders);
    }

    /**
     * @return NotificationProviderInterface[]
     */
    public function getNotificationProviders(): array
    {
        return $this->notificationProviders;
    }
}
