<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('randock_admin_press');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('locales')
                    ->arrayPrototype()
                    ->beforeNormalization()
                        ->ifTrue(function ($locale) {
                            return !isset($locale['icon']);
                        })
                        ->then(function ($locale) {
                            $locale['icon'] = $locale['code'];

                            return $locale;
                        })
                    ->end()
                    ->children()
                        ->scalarNode('code')->isRequired()->end()
                        ->scalarNode('name')->isRequired()->end()
                        ->scalarNode('icon')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
