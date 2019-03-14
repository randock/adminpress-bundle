<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Randock\AdminPressBundle\Model\Notification\NotificationProviderInterface;
use Randock\AdminPressBundle\DependencyInjection\Compiler\Exception\ServiceDoesNotImplementNotificationProviderInterfaceException;

class NotificationsPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     *
     * @throws ServiceDoesNotImplementNotificationProviderInterfaceException
     * @throws \ReflectionException
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('randock_admin_press.notification_provider');

        $collector = $container->getDefinition('randock_admin_press.notification_provider_collector');

        $sortedServices = [];

        foreach ($taggedServices as $service => $tags) {
            $sortedServices[$service] = $tags[0]['priority'] ?? INF;
        }
        \asort($sortedServices);

        foreach (\array_keys($sortedServices) as $service) {
            $serviceDefinition = $container->findDefinition($service);
            $reflectionClass = new \ReflectionClass($serviceDefinition->getClass());

            if (!$reflectionClass->implementsInterface(NotificationProviderInterface::class)) {
                throw new ServiceDoesNotImplementNotificationProviderInterfaceException($serviceDefinition->getClass());
            }
            $collector->addMethodCall('addNotificationProvider', [$serviceDefinition]);
        }
    }
}
