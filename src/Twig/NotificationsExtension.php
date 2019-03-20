<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Twig;

use Randock\AdminPressBundle\Model\Notification\NotificationProviderCollector;

class NotificationsExtension extends \Twig_Extension
{
    /**
     * @var NotificationProviderCollector
     */
    private $collector;

    /**
     * NotificationsExtension constructor.
     *
     * @param NotificationProviderCollector $collector
     */
    public function __construct(NotificationProviderCollector $collector)
    {
        $this->collector = $collector;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'notifications',
                [$this, 'renderNotifications'],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }

    public function renderNotifications(
        \Twig_Environment $environment,
        string $template = '@RandockAdminPress/components/notification/all.html.twig'
    ) {
        return $environment->render($template, ['providers' => $this->collector->getNotificationProviders()]);
    }
}
