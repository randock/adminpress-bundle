<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\FactoryInterface;

interface MenuItemProviderInterface
{
    /**
     * @param ItemInterface    $menu
     * @param FactoryInterface $factory
     *
     * @return ItemInterface
     */
    public function addItems(ItemInterface $menu, FactoryInterface $factory): ItemInterface;
}
