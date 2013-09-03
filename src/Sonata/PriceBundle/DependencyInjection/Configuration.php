<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\PriceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Intl\Intl;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('sonata_price');

        $this->addPriceSection($node);

        return $treeBuilder;
    }

    /**
     * @param  \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     * @return void
     */
    private function addPriceSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('currency')
                    ->isRequired()
                    ->validate()
                    ->ifNotInArray(array_keys(Intl::getCurrencyBundle()->getCurrencyNames()))
                        ->thenInvalid("Invalid currency '%s'")
                    ->end()
                ->end()
            ->end()
        ;
    }
}