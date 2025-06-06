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
namespace PhpCsFixer\Console\Output\Progress;

use PhpCsFixer\Runner\Event\FileProcessed;
/**
 * @internal
 */
interface ProgressOutputInterface
{
    public function printLegend() : void;
    public function onFixerFileProcessed(FileProcessed $event) : void;
}
