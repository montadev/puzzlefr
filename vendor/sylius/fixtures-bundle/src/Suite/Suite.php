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

namespace Sylius\Bundle\FixturesBundle\Suite;

use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Bundle\FixturesBundle\Listener\ListenerInterface;

final class Suite implements SuiteInterface
{
    private PriorityQueue $fixtures;

    private PriorityQueue $listeners;

    public function __construct(private string $name)
    {
        $this->fixtures = new PriorityQueue();
        $this->listeners = new PriorityQueue();
    }

    /** @param array<mixed> $options */
    public function addFixture(FixtureInterface $fixture, array $options, int $priority = 0): void
    {
        $this->fixtures->insert(['fixture' => $fixture, 'options' => $options], $priority);
    }

    /** @param array<mixed> $options */
    public function addListener(ListenerInterface $listener, array $options, int $priority = 0): void
    {
        $this->listeners->insert(['listener' => $listener, 'options' => $options], $priority);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFixtures(): iterable
    {
        foreach ($this->fixtures as $fixture) {
            yield $fixture['fixture'] => $fixture['options'];
        }
    }

    public function getListeners(): iterable
    {
        foreach ($this->listeners as $listener) {
            yield $listener['listener'] => $listener['options'];
        }
    }
}
