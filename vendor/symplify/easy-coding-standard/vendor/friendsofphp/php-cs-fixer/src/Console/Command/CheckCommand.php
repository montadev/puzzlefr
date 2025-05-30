<?php

declare (strict_types=1);
/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Console\Command;

use PhpCsFixer\ToolInfoInterface;
use ECSPrefix202503\Symfony\Component\Console\Attribute\AsCommand;
use ECSPrefix202503\Symfony\Component\Console\Input\InputInterface;
use ECSPrefix202503\Symfony\Component\Console\Input\InputOption;
/**
 * @author Greg Korba <greg@codito.dev>
 *
 * @internal
 */
final class CheckCommand extends \PhpCsFixer\Console\Command\FixCommand
{
    protected static $defaultName = 'check';
    protected static $defaultDescription = 'Checks if configured files/directories comply with configured rules.';
    public function __construct(ToolInfoInterface $toolInfo)
    {
        parent::__construct($toolInfo);
    }
    public function getHelp() : string
    {
        $help = \explode('<comment>--dry-run</comment>', parent::getHelp());
        return \substr($help[0], 0, \strrpos($help[0], "\n") - 1) . \substr($help[1], \strpos($help[1], "\n"));
    }
    protected function configure() : void
    {
        parent::configure();
        $this->setDefinition(\array_merge(\array_values($this->getDefinition()->getArguments()), \array_values(\array_filter($this->getDefinition()->getOptions(), static function (InputOption $option) : bool {
            return 'dry-run' !== $option->getName();
        }))));
    }
    protected function isDryRun(InputInterface $input) : bool
    {
        return \true;
    }
}
