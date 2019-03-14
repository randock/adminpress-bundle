<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Menu;

use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MainMenuBuilder extends MenuBuilder
{
    /**
     * @param string       $menuName
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createMenu(string $menuName, RequestStack $requestStack): ItemInterface
    {
        /** @var ItemInterface $menu */
        $menu = $this->factory->createItem($menuName);

        $this->loadServices($menu, $this->factory);

        $this->reorderMenuItems($menu);

        return $menu;
    }
}
