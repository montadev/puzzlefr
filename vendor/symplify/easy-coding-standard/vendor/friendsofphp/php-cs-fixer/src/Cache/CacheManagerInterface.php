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
namespace PhpCsFixer\Cache;

/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
interface CacheManagerInterface
{
    public function needFixing(string $file, string $fileContent) : bool;
    public function setFile(string $file, string $fileContent) : void;
    public function setFileHash(string $file, string $hash) : void;
}
