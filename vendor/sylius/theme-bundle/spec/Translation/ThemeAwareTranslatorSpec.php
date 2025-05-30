<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Sylius\Bundle\ThemeBundle\Translation;

use PhpSpec\ObjectBehavior;
use Sylius\Bundle\ThemeBundle\Context\ThemeContextInterface;
use Sylius\Bundle\ThemeBundle\Model\ThemeInterface;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Translation\MessageCatalogueInterface;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ThemeAwareTranslatorSpec extends ObjectBehavior
{
    function let(TranslatorInterface $translator, ThemeContextInterface $themeContext): void
    {
        $translator->implement(TranslatorBagInterface::class);
        $translator->implement(LocaleAwareInterface::class);

        $this->beConstructedWith($translator, $themeContext);
    }

    function it_implements_translator_interface(): void
    {
        $this->shouldImplement(TranslatorInterface::class);
    }

    function it_implements_translator_bag_interface(): void
    {
        $this->shouldImplement(TranslatorBagInterface::class);
    }

    function it_implements_warmable_interface(): void
    {
        $this->shouldImplement(WarmableInterface::class);
    }

    function it_proxies_getting_the_locale_to_the_decorated_translator(TranslatorInterface $translator): void
    {
        $translator->getLocale()->willReturn('pl_PL');

        $this->getLocale()->shouldReturn('pl_PL');
    }

    function it_proxies_setting_the_locale_to_the_decorated_translator(TranslatorInterface $translator): void
    {
        $translator->setLocale('pl_PL')->shouldBeCalled();

        $this->setLocale('pl_PL');
    }

    function it_proxies_getting_catalogue_for_given_locale_to_the_decorated_translator(
        TranslatorBagInterface $translator,
        MessageCatalogueInterface $messageCatalogue,
    ): void {
        $translator->getCatalogue('pl_PL')->willReturn($messageCatalogue);

        $this->getCatalogue('pl_PL')->shouldReturn($messageCatalogue);
    }

    function it_just_proxies_translating(TranslatorInterface $translator, ThemeContextInterface $themeContext): void
    {
        $themeContext->getTheme()->willReturn(null);

        $translator->trans('id', ['param'], 'domain', null)->willReturn('translated string');

        $this->trans('id', ['param'], 'domain')->shouldReturn('translated string');
    }

    function it_just_proxies_translating_with_custom_locale(TranslatorInterface $translator, ThemeContextInterface $themeContext): void
    {
        $themeContext->getTheme()->willReturn(null);

        $translator->trans('id', ['param'], 'domain', 'customlocale')->willReturn('translated string');

        $this->trans('id', ['param'], 'domain', 'customlocale')->shouldReturn('translated string');
    }

    function it_proxies_translating_with_modified_default_locale(
        TranslatorInterface $translator,
        ThemeContextInterface $themeContext,
        ThemeInterface $theme,
    ): void {
        $themeContext->getTheme()->willReturn($theme);
        $theme->getName()->willReturn('theme/name');

        $translator->getLocale()->willReturn('defaultlocale');
        $translator->trans('id', ['param'], 'domain', 'defaultlocale@theme-name')->willReturn('translated string');

        $this->trans('id', ['param'], 'domain')->shouldReturn('translated string');
    }

    function it_proxies_translating_with_modified_custom_locale(
        TranslatorInterface $translator,
        ThemeContextInterface $themeContext,
        ThemeInterface $theme,
    ): void {
        $themeContext->getTheme()->willReturn($theme);
        $theme->getName()->willReturn('theme/name');

        $translator->trans('id', ['param'], 'domain', 'customlocale@theme-name')->willReturn('translated string');

        $this->trans('id', ['param'], 'domain', 'customlocale')->shouldReturn('translated string');
    }

    function it_does_not_warm_up_if_decorated_translator_is_not_warmable(): void
    {
        $this->warmUp('cache');
    }

    function it_warms_up_if_decorated_translator_is_warmable(WarmableInterface $translator): void
    {
        $translator->warmUp('cache')->shouldBeCalled()->willReturn([]);

        $this->warmUp('cache');
    }
}
