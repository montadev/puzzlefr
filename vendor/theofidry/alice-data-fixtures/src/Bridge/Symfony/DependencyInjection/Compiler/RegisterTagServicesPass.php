<?php

/*
 * This file is part of the Fidry\AliceDataFixtures package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fidry\AliceDataFixtures\Bridge\Symfony\DependencyInjection\Compiler;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @private
 */
final readonly class RegisterTagServicesPass implements CompilerPassInterface
{
    private TaggedDefinitionsLocator $taggedDefinitionsLocator;

    #[Pure]
    public function __construct(private string $registry, private string $tagName)
    {
        $this->taggedDefinitionsLocator = new TaggedDefinitionsLocator();
    }

    public function process(ContainerBuilder $container): void
    {
        if (false === $container->hasDefinition($this->registry)) {
            return;
        }

        $registry = $container->findDefinition($this->registry);
        $taggedServices = $this->taggedDefinitionsLocator->findReferences($container, $this->tagName);

        $registry->addArgument($taggedServices);
    }
}
