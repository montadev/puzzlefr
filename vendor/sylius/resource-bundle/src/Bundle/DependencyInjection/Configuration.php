<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ResourceBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Form\Type\DefaultResourceType;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sylius_resource');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $this->addResourcesSection($rootNode);
        $this->addSettingsSection($rootNode);
        $this->addTranslationsSection($rootNode);
        $this->addDriversSection($rootNode);

        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('paths')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('authorization_checker')
                    ->defaultValue('sylius.resource_controller.authorization_checker.disabled')
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    private function addResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
                            ->variableNode('options')
                                ->setDeprecated('sylius/resource-bundle', '1.12', 'The "%node%" node at "%path%" is deprecated and will be removed in 2.0.')
                            ->end()
                            ->scalarNode('templates')->cannotBeEmpty()->end()
                            ->scalarNode('state_machine_component')->defaultNull()->end()
                            ->arrayNode('classes')
                                ->isRequired()
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('model')->isRequired()->cannotBeEmpty()->end()
                                    ->scalarNode('interface')->cannotBeEmpty()->end()
                                    ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                    ->scalarNode('repository')->cannotBeEmpty()->end()
                                    ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                    ->scalarNode('form')->defaultValue(DefaultResourceType::class)->cannotBeEmpty()->end()
                                ->end()
                            ->end()
                            ->arrayNode('translation')
                                ->children()
                                    ->variableNode('options')
                                        ->setDeprecated('sylius/resource-bundle', '1.12', 'The "%node%" node at "%path%" is deprecated and will be removed in 2.0.')
                                    ->end()
                                    ->arrayNode('classes')
                                        ->isRequired()
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->scalarNode('model')->isRequired()->cannotBeEmpty()->end()
                                            ->scalarNode('interface')->cannotBeEmpty()->end()
                                            ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                            ->scalarNode('repository')->cannotBeEmpty()->end()
                                            ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                            ->scalarNode('form')->defaultValue(DefaultResourceType::class)->cannotBeEmpty()->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addSettingsSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('settings')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('paginate')->defaultNull()->end()
                        ->variableNode('limit')->defaultNull()->end()
                        ->arrayNode('allowed_paginate')
                            ->integerPrototype()->end()
                            ->defaultValue([10, 20, 30])
                        ->end()
                        ->integerNode('default_page_size')->defaultValue(10)->end()
                        ->scalarNode('default_templates_dir')->defaultNull()->end()
                        ->booleanNode('sortable')->defaultFalse()->end()
                        ->variableNode('sorting')->defaultNull()->end()
                        ->booleanNode('filterable')->defaultFalse()->end()
                        ->variableNode('criteria')->defaultNull()->end()
                        ->scalarNode('state_machine_component')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addTranslationsSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('translation')
                    ->canBeDisabled()
                    ->children()
                        ->scalarNode('locale_provider')->defaultValue('sylius.translation_locale_provider.immutable')->cannotBeEmpty()->end()
                ->end()
            ->end()
        ;
    }

    private function addDriversSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('drivers')
                    ->defaultValue([])
                    ->enumPrototype()->values(SyliusResourceBundle::getAvailableDrivers())->end()
                ->end()
            ->end()
        ;
    }
}
