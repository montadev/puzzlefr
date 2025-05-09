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

namespace Sylius\Resource\Symfony\Routing\Factory\RoutePath;

use Sylius\Resource\Metadata\Operation;

/**
 * @experimental
 */
final class OperationRoutePathFactory implements OperationRoutePathFactoryInterface
{
    public function createRoutePath(Operation $operation, string $rootPath): string
    {
        throw new \InvalidArgumentException(sprintf('Impossible to get a default route path for operation "%s". Please define a path.', $operation->getName() ?? ''));
    }
}
