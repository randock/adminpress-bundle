<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ProfileMenuBuilder extends MenuBuilder
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
        $menu = $this->factory->createItem($menuName, [
            'childrenAttributes' => [
                'class' => 'dropdown-user',
            ],
        ]);

        $this->loadServices($menu, $this->factory);

        $this->reorderMenuItems($menu);

        return $menu;
    }

    public function loadServices(ItemInterface $menu, FactoryInterface $factory): void
    {
        foreach ($this->services as $service) {
            /** @var ItemInterface $menu */
            $menu = $this->container->get($service)->addItems($menu, $factory);

            if ($service !== \end($this->services)) {
                $separator = $menu->addChild(\microtime());
                $separator->setAttributes([
                   'class' => 'divider',
                   'role' => 'separator',
                ]);
            }
        }
    }
}
