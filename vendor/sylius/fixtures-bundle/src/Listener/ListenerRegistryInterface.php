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

namespace Sylius\Bundle\FixturesBundle\Listener;

interface ListenerRegistryInterface
{
    /**
     * @throws ListenerNotFoundException
     */
    public function getListener(string $name): ListenerInterface;

    /**
     * @return array<string, ListenerInterface> Name indexed
     */
    public function getListeners(): array;
}
