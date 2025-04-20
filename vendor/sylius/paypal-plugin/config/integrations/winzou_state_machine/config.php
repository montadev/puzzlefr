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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator, ContainerBuilder $container): void {
    /** @var array<string> $bundles */
    $bundles = $container->getParameter('kernel.bundles');

    if (isset($bundles['winzouStateMachineBundle'])) {
        $configurator->import('winzou_state_machine/**/*.yaml');
    }
};
