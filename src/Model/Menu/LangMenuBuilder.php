<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\Model\Menu;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class LangMenuBuilder
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var array
     */
    protected $locales;

    /**
     * @var string|null
     */
    protected $langSwitcher;

    /**
     * LangMenuBuilder constructor.
     *
     * @param RequestStack    $requestStack
     * @param RouterInterface $router
     * @param array           $locales
     * @param string|null     $langSwitcher
     */
    public function __construct(RequestStack $requestStack, RouterInterface $router, array $locales, string $langSwitcher = null)
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->locales = $locales;
        $this->langSwitcher = $langSwitcher;
    }

    public function getCurrentLocale(): array
    {
        $locale = $this->requestStack->getCurrentRequest()->getLocale();

        foreach ($this->locales as $l) {
            if ($locale === $l['code'] || strlen($l['code']) >= 2 && $locale === substr($l['code'], 0, 2)) {
                return $l;
            }
        }

        $defaultLocale = $this->requestStack->getCurrentRequest()->getDefaultLocale();

        return [
            'code' => $defaultLocale,
            'name' => $defaultLocale,
            'icon' => $defaultLocale,
        ];
    }

    public function getLangOptions(): array
    {
        $current = $this->getCurrentLocale();

        return \array_filter($this->locales, function ($var) use ($current) {
            return $current['code'] !== $var['code'];
        });
    }
}
