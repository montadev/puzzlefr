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

namespace Sylius\Resource\Symfony\Routing\Factory\RouteName;

use Sylius\Resource\Metadata\Operation;

/**
 * @experimental
 */
final class OperationRouteNameFactory implements OperationRouteNameFactoryInterface
{
    public function createRouteName(Operation $operation, ?string $shortName = null): string
    {
        $resource = $operation->getResource();

        if (null === $resource) {
            throw new \RuntimeException(sprintf('No resource was found on the operation "%s"', $operation->getShortName() ?? ''));
        }

        $section = $resource->getSection();
        $sectionPrefix = $section ? $section . '_' : '';

        return sprintf(
            '%s_%s%s_%s',
            $resource->getApplicationName() ?? '',
            $sectionPrefix,
            $resource->getName() ?? '',
            $shortName ?? $operation->getShortName() ?? '',
        );
    }
}
