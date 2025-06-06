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

interface AfterFixtureListenerInterface extends ListenerInterface
{
    /** @param array<mixed> $options */
    public function afterFixture(FixtureEvent $fixtureEvent, array $options): void;
}
