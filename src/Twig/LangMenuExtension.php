<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Twig;

use Randock\AdminPressBundle\Model\Menu\LangMenuBuilder;

class LangMenuExtension extends \Twig_Extension
{
    /**
     * @var LangMenuBuilder
     */
    private $menuBuilder;

    public function __construct(LangMenuBuilder $menuBuilder)
    {
        $this->menuBuilder = $menuBuilder;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('lang_options_current', [$this->menuBuilder, 'getCurrentLocale']),
            new \Twig_SimpleFunction('lang_options_others', [$this->menuBuilder, 'getLangOptions']),
        ];
    }
}
