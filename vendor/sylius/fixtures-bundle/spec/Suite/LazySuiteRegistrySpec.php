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

namespace spec\Sylius\Bundle\FixturesBundle\Suite;

use PhpSpec\ObjectBehavior;
use Sylius\Bundle\FixturesBundle\Suite\SuiteFactoryInterface;
use Sylius\Bundle\FixturesBundle\Suite\SuiteInterface;
use Sylius\Bundle\FixturesBundle\Suite\SuiteNotFoundException;
use Sylius\Bundle\FixturesBundle\Suite\SuiteRegistryInterface;

final class LazySuiteRegistrySpec extends ObjectBehavior
{
    function let(SuiteFactoryInterface $suiteFactory): void
    {
        $this->beConstructedWith($suiteFactory);
    }

    function it_implements_suite_registry_interface(): void
    {
        $this->shouldImplement(SuiteRegistryInterface::class);
    }

    function it_returns_a_constructed_suite(SuiteFactoryInterface $suiteFactory, SuiteInterface $suite): void
    {
        $this->addSuite('suite_name', ['fixtures' => []]);

        $suiteFactory->createSuite('suite_name', ['fixtures' => []])->willReturn($suite);

        $this->getSuite('suite_name')->shouldReturn($suite);
        $this->getSuites()->shouldReturn(['suite_name' => $suite]);
    }

    function it_constructs_a_suite_only_once(SuiteFactoryInterface $suiteFactory, SuiteInterface $suite): void
    {
        $this->addSuite('suite_name', ['fixtures' => []]);

        $suiteFactory->createSuite('suite_name', ['fixtures' => []])->shouldBeCalledTimes(1)->willReturn($suite);

        $this->getSuite('suite_name')->shouldReturn($suite);
        $this->getSuite('suite_name')->shouldReturn($suite);
    }

    function it_returns_an_empty_suites_list_if_none_was_registered(): void
    {
        $this->getSuites()->shouldReturn([]);
    }

    function it_throws_an_exception_if_trying_to_get_unexisting_suite(): void
    {
        $this->shouldThrow(SuiteNotFoundException::class)->during('getSuite', ['the_river_snake_is_dangerous']);
    }
}
