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

namespace Sylius\Bundle\ThemeBundle\Translation;

use Sylius\Bundle\ThemeBundle\Translation\Provider\Loader\TranslatorLoaderProviderInterface;
use Sylius\Bundle\ThemeBundle\Translation\Provider\Resource\TranslatorResourceProviderInterface;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\Formatter\MessageFormatterInterface;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator as BaseTranslator;

final class Translator extends BaseTranslator implements WarmableInterface
{
    protected array $options = [
        'cache_dir' => null,
        'debug' => false,
    ];

    /** @psalm-suppress PropertyNotSetInConstructor It is set in the constructor though */
    private TranslatorLoaderProviderInterface $loaderProvider;

    /** @psalm-suppress PropertyNotSetInConstructor It is set in the constructor though */
    private TranslatorResourceProviderInterface $resourceProvider;

    private bool $resourcesLoaded = false;

    /**
     * @param MessageSelector|MessageFormatterInterface $messageFormatterOrSelector
     */
    public function __construct(
        TranslatorLoaderProviderInterface $loaderProvider,
        TranslatorResourceProviderInterface $resourceProvider,
        $messageFormatterOrSelector,
        string $locale,
        array $options = [],
    ) {
        $this->assertOptionsAreKnown($options);

        $this->loaderProvider = $loaderProvider;
        $this->resourceProvider = $resourceProvider;

        $this->options = array_merge($this->options, $options);
        if (null !== $this->options['cache_dir'] && $this->options['debug']) {
            $this->addResources();
        }

        parent::__construct($locale, $this->provideMessageFormatter($messageFormatterOrSelector), $this->options['cache_dir'], $this->options['debug']);
    }

    /**
     * @psalm-suppress MissingParamType
     * @psalm-suppress MissingReturnType
     */
    public function warmUp($cacheDir, ?string $buildDir = null): array
    {
        // skip warmUp when translator doesn't use cache
        if (null === $this->options['cache_dir']) {
            return [];
        }

        /** @psalm-suppress InternalMethod */
        $locales = array_merge(
            $this->getFallbackLocales(),
            [$this->getLocale()],
            $this->resourceProvider->getResourcesLocales(),
        );
        foreach (array_unique($locales) as $locale) {
            // reset catalogue in case it's already loaded during the dump of the other locales.
            if (isset($this->catalogues[$locale])) {
                unset($this->catalogues[$locale]);
            }

            $this->loadCatalogue($locale);
        }

        return [];
    }

    /**
     * @param string $locale
     */
    protected function initializeCatalogue($locale): void
    {
        $this->initialize();

        parent::initializeCatalogue($locale);
    }

    /**
     * @param string $locale
     */
    protected function computeFallbackLocales($locale): array
    {
        $themeModifier = $this->getLocaleModifier($locale);
        $localeWithoutModifier = $this->getLocaleWithoutModifier($locale, $themeModifier);

        $computedFallbackLocales = parent::computeFallbackLocales($locale);
        array_unshift($computedFallbackLocales, $localeWithoutModifier);

        $fallbackLocales = [];
        foreach (array_diff($computedFallbackLocales, [$locale]) as $computedFallback) {
            $fallback = $computedFallback . $themeModifier;
            if ('' !== $themeModifier && $locale !== $fallback) {
                $fallbackLocales[] = $fallback;
            }

            $fallbackLocales[] = $computedFallback;
        }

        return array_unique($fallbackLocales);
    }

    private function getLocaleModifier(string $locale): string
    {
        $modifier = strrchr($locale, '@');

        return $modifier !== false ? $modifier : '';
    }

    private function getLocaleWithoutModifier(string $locale, string $modifier): string
    {
        return str_replace($modifier, '', $locale);
    }

    private function initialize(): void
    {
        $this->addResources();
        $this->addLoaders();
    }

    private function addResources(): void
    {
        if ($this->resourcesLoaded) {
            return;
        }

        $resources = $this->resourceProvider->getResources();
        foreach ($resources as $resource) {
            $this->addResource(
                $resource->getFormat(),
                $resource->getName(),
                $resource->getLocale(),
                $resource->getDomain(),
            );
        }

        $this->resourcesLoaded = true;
    }

    private function addLoaders(): void
    {
        $loaders = $this->loaderProvider->getLoaders();
        foreach ($loaders as $alias => $loader) {
            $this->addLoader($alias, $loader);
        }
    }

    private function assertOptionsAreKnown(array $options): void
    {
        if ($diff = array_diff(array_keys($options), array_keys($this->options))) {
            throw new \InvalidArgumentException(sprintf('The Translator does not support the following options: \'%s\'.', implode('\', \'', $diff)));
        }
    }

    /**
     * @param mixed $messageFormatterOrSelector
     */
    private function provideMessageFormatter($messageFormatterOrSelector): MessageFormatterInterface
    {
        if ($messageFormatterOrSelector instanceof MessageSelector) {
            @trigger_error(sprintf('Passing a "%s" instance into the "%s" as a third argument is deprecated since Sylius 1.2 and will be removed in 2.0. Inject a "%s" implementation instead.', MessageSelector::class, __METHOD__, MessageFormatterInterface::class), \E_USER_DEPRECATED);

            /** @psalm-suppress InvalidArgument */
            return new MessageFormatter($this, $messageFormatterOrSelector);
        }

        if ($messageFormatterOrSelector instanceof MessageFormatterInterface) {
            return $messageFormatterOrSelector;
        }

        throw new \UnexpectedValueException(sprintf(
            'Expected an instance of "%s" or "%s", got "%s"!',
            MessageFormatterInterface::class,
            MessageSelector::class,
            is_object($messageFormatterOrSelector) ? get_class($messageFormatterOrSelector) : gettype($messageFormatterOrSelector),
        ));
    }
}
