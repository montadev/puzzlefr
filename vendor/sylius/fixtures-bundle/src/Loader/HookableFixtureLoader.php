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

namespace Sylius\Bundle\FixturesBundle\Loader;

use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Bundle\FixturesBundle\Listener\AfterFixtureListenerInterface;
use Sylius\Bundle\FixturesBundle\Listener\BeforeFixtureListenerInterface;
use Sylius\Bundle\FixturesBundle\Listener\FixtureEvent;
use Sylius\Bundle\FixturesBundle\Suite\SuiteInterface;

final class HookableFixtureLoader implements FixtureLoaderInterface
{
    public function __construct(private FixtureLoaderInterface $decoratedFixtureLoader)
    {
    }

    public function load(SuiteInterface $suite, FixtureInterface $fixture, array $options): void
    {
        $fixtureEvent = new FixtureEvent($suite, $fixture, $options);

        $this->executeBeforeFixtureListeners($suite, $fixtureEvent);

        $this->decoratedFixtureLoader->load($suite, $fixture, $options);

        $this->executeAfterFixtureListeners($suite, $fixtureEvent);
    }

    private function executeBeforeFixtureListeners(SuiteInterface $suite, FixtureEvent $fixtureEvent): void
    {
        foreach ($suite->getListeners() as $listener => $listenerOptions) {
            if (!$listener instanceof BeforeFixtureListenerInterface) {
                continue;
            }

            $listener->beforeFixture($fixtureEvent, $listenerOptions);
        }
    }

    private function executeAfterFixtureListeners(SuiteInterface $suite, FixtureEvent $fixtureEvent): void
    {
        foreach ($suite->getListeners() as $listener => $listenerOptions) {
            if (!$listener instanceof AfterFixtureListenerInterface) {
                continue;
            }

            $listener->afterFixture($fixtureEvent, $listenerOptions);
        }
    }
}
