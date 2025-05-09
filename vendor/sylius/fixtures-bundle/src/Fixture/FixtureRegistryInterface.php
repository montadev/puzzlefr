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

namespace Sylius\Bundle\FixturesBundle\Fixture;

interface FixtureRegistryInterface
{
    /**
     * @throws FixtureNotFoundException
     */
    public function getFixture(string $name): FixtureInterface;

    /**
     * @return array|FixtureInterface[] Name indexed
     */
    public function getFixtures(): array;
}
