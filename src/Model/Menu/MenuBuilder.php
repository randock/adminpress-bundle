<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $services;

    /**
     * MenuBuilder constructor.
     *
     * @param FactoryInterface   $factory
     * @param ContainerInterface $container
     */
    public function __construct(FactoryInterface $factory, ContainerInterface $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }

    /**
     * @param array $services
     */
    public function setServices(array $services): void
    {
        $this->services = $services;
    }

    /**
     * @param ItemInterface    $menu
     * @param FactoryInterface $factory
     */
    public function loadServices(ItemInterface $menu, FactoryInterface $factory): void
    {
        foreach ($this->services as $service) {
            $menu = $this->container->get($service)->addItems($menu, $factory);
        }
    }

    /**
     * @param ItemInterface $menu
     */
    protected function reorderMenuItems(ItemInterface $menu): void
    {
        $menuOrderArray = [];

        $addLast = [];

        foreach ($menu->getChildren() as $key => $menuItem) {
            if ($menuItem->hasChildren()) {
                $this->reorderMenuItems($menuItem);
            }

            $orderNumber = $menuItem->getExtra('orderNumber');

            if (null !== $orderNumber) {
                $menuOrderArray[$menuItem->getName()] = $orderNumber;
            } else {
                $addLast[] = $menuItem->getName();
            }
        }

        // sort them after first pass
        \asort($menuOrderArray);

        $menuOrderArray = \array_keys($menuOrderArray);

        // add items without ordernumber to the end
        if (\count($addLast)) {
            foreach ($addLast as $item) {
                $menuOrderArray[] = $item;
            }
        }

        if (\count($menuOrderArray)) {
            $menu->reorderChildren($menuOrderArray);
        }
    }
}
