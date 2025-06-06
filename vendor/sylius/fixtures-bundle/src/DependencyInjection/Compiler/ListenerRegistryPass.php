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

namespace Sylius\Bundle\FixturesBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ListenerRegistryPass implements CompilerPassInterface
{
    public const LISTENER_SERVICE_TAG = 'sylius_fixtures.listener';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('sylius_fixtures.listener_registry')) {
            return;
        }

        $listenerRegistry = $container->findDefinition('sylius_fixtures.listener_registry');

        $taggedServices = $container->findTaggedServiceIds(self::LISTENER_SERVICE_TAG);
        foreach (array_keys($taggedServices) as $id) {
            $listenerRegistry->addMethodCall('addListener', [new Reference($id)]);
        }
    }
}
