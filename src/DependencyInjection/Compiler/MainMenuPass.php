<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Randock\AdminPressBundle\Model\Menu\MenuItemProviderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Randock\AdminPressBundle\DependencyInjection\Compiler\Exception\ServiceDoesNotImplementMenuItemProviderInterfaceException;

class MainMenuPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('randock_admin_press.main_menu_add_items');

        $definition = $container->getDefinition('randock_admin_press.menu.main_menu_builder');

        $sortedServices = [];

        foreach ($taggedServices as $service => $tags) {
            $serviceDefinition = $container->findDefinition($service);
            $reflectionClass = new \ReflectionClass($serviceDefinition->getClass());
            if (!$reflectionClass->implementsInterface(MenuItemProviderInterface::class)) {
                throw new ServiceDoesNotImplementMenuItemProviderInterfaceException($serviceDefinition->getClass());
            }
            $sortedServices[$service] = $tags[0]['priority'] ?? INF;
        }

        \asort($sortedServices);

        $definition->addMethodCall('setServices', [\array_keys($sortedServices)]);
    }
}
