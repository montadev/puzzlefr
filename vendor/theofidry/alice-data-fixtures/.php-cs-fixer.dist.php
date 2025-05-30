<?php

/*
 * This file is part of the Fidry\AliceDataFixtures package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__.'/fixtures',
        __DIR__.'/migrations',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->exclude(
        'fixtures/Bridge/Symfony/SymfonyApp/cache',
    )
    ->append([
        __DIR__.'/.php_cs.dist',
        __DIR__.'/bin/console',
        __DIR__.'/bin/doctrine_purge',
        __DIR__.'/bin/eloquent_migrate',
        __DIR__.'/bin/eloquent_rollback',
    ])
;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'blank_line_after_opening_tag' => true,
        'cast_spaces' => true,
        'combine_consecutive_unsets' => true,
        'declare_equal_normalize' => true,
        'declare_strict_types' => true,
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'inheritDoc',
            ],
        ],
        'heredoc_to_nowdoc' => true,
        'header_comment' => [
            'location' => 'after_open',
            'header' => <<<'LICENSE'
            This file is part of the Fidry\AliceDataFixtures package.
            
            (c) Théo FIDRY <theo.fidry@gmail.com>
            
            For the full copyright and license information, please view the LICENSE
            file that was distributed with this source code.
            LICENSE
        ],
        'include' => true,
        'lowercase_cast' => true,
        'modernize_types_casting' => true,
        'native_function_casing' => true,
        'new_with_braces' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_short_bool_cast' => true,
        'no_spaces_around_offset' => true,
        'no_unused_imports' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_trim' => true,
        'php_unit_fqcn_annotation' => true,
        'php_unit_test_class_requires_covers' => true,
        'single_quote' => true,
        'space_after_semicolon' => true,
        'standardize_not_equals' => true,
        'trim_array_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder)
    ;
