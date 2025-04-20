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

namespace Sylius\TwigHooks\Hookable\Renderer\Debug;

use Sylius\TwigHooks\Hookable\AbstractHookable;
use Sylius\TwigHooks\Hookable\HookableComponent;
use Sylius\TwigHooks\Hookable\HookableTemplate;
use Sylius\TwigHooks\Hookable\Metadata\HookableMetadata;
use Sylius\TwigHooks\Hookable\Renderer\HookableRendererInterface;

final class HookableDebugCommentRenderer implements HookableRendererInterface
{
    public function __construct(private readonly HookableRendererInterface $innerRenderer)
    {
    }

    public function render(AbstractHookable $hookable, HookableMetadata $metadata): string
    {
        $renderedParts = [];
        $renderedParts[] = $this->getOpeningDebugComment($hookable);
        $renderedParts[] = trim($this->innerRenderer->render($hookable, $metadata));
        $renderedParts[] = $this->getClosingDebugComment($hookable);

        return implode(\PHP_EOL, $renderedParts);
    }

    private function getOpeningDebugComment(AbstractHookable $hookable): string
    {
        [$targetName, $targetValue] = match (get_class($hookable)) {
            HookableTemplate::class => ['template', $hookable->template],
            HookableComponent::class => ['component', $hookable->component],
            default => throw new \InvalidArgumentException('Unsupported hookable type.'),
        };

        return sprintf(
            '<!-- BEGIN HOOKABLE | hook: "%s", name: "%s", %s: "%s", priority: %d -->',
            $hookable->hookName,
            $hookable->name,
            $targetName,
            $targetValue,
            $hookable->priority(),
        );
    }

    private function getClosingDebugComment(AbstractHookable $hookable): string
    {
        [$targetName, $targetValue] = match (get_class($hookable)) {
            HookableTemplate::class => ['template', $hookable->template],
            HookableComponent::class => ['component', $hookable->component],
            default => throw new \InvalidArgumentException('Unsupported hookable type.'),
        };

        return sprintf(
            '<!--  END HOOKABLE  | hook: "%s", name: "%s", %s: "%s", priority: %d -->',
            $hookable->hookName,
            $hookable->name,
            $targetName,
            $targetValue,
            $hookable->priority(),
        );
    }
}
