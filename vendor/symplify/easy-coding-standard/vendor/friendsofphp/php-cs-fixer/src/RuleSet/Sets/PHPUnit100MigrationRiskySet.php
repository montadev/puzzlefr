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
namespace PhpCsFixer\RuleSet\Sets;

use PhpCsFixer\RuleSet\AbstractMigrationSetDescription;
/**
 * @internal
 */
final class PHPUnit100MigrationRiskySet extends AbstractMigrationSetDescription
{
    public function getRules() : array
    {
        return ['@PHPUnit91Migration:risky' => \true, 'php_unit_data_provider_static' => ['force' => \true]];
    }
}
