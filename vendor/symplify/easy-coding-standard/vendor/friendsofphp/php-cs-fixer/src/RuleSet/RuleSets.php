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
namespace PhpCsFixer\RuleSet;

use ECSPrefix202503\Symfony\Component\Finder\Finder;
/**
 * Set of rule sets to be used by fixer.
 *
 * @internal
 */
final class RuleSets
{
    /**
     * @var null|array<string, RuleSetDescriptionInterface>
     */
    private static $setDefinitions;
    /**
     * @return array<string, RuleSetDescriptionInterface>
     */
    public static function getSetDefinitions() : array
    {
        if (null === self::$setDefinitions) {
            self::$setDefinitions = [];
            foreach (Finder::create()->files()->in(__DIR__ . '/Sets') as $file) {
                $class = 'PhpCsFixer\\RuleSet\\Sets\\' . $file->getBasename('.php');
                /** @var RuleSetDescriptionInterface */
                $set = new $class();
                self::$setDefinitions[$set->getName()] = $set;
            }
            \uksort(self::$setDefinitions, static function (string $x, string $y) : int {
                return \strnatcmp($x, $y);
            });
        }
        return self::$setDefinitions;
    }
    /**
     * @return list<string>
     */
    public static function getSetDefinitionNames() : array
    {
        return \array_keys(self::getSetDefinitions());
    }
    public static function getSetDefinition(string $name) : \PhpCsFixer\RuleSet\RuleSetDescriptionInterface
    {
        $definitions = self::getSetDefinitions();
        if (!isset($definitions[$name])) {
            throw new \InvalidArgumentException(\sprintf('Set "%s" does not exist.', $name));
        }
        return $definitions[$name];
    }
}
