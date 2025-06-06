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

use Webmozart\Assert\Assert;

final class FixtureRegistry implements FixtureRegistryInterface
{
    /** @var array<string, FixtureInterface> */
    private array $fixtures = [];

    public function addFixture(FixtureInterface $fixture): void
    {
        Assert::keyNotExists($this->fixtures, $fixture->getName(), 'Fixture with name "%s" is already registered.');

        $this->fixtures[$fixture->getName()] = $fixture;
    }

    public function getFixture(string $name): FixtureInterface
    {
        if (!isset($this->fixtures[$name])) {
            throw new FixtureNotFoundException($name);
        }

        return $this->fixtures[$name];
    }

    public function getFixtures(): array
    {
        return $this->fixtures;
    }
}
