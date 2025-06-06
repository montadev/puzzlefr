<?php

declare (strict_types=1);
namespace ECSPrefix202503;

use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\Basic\BracesPositionFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Basic\NoMultipleStatementsPerLineFixer;
use PhpCsFixer\Fixer\Casing\ConstantCaseFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareParenthesesFixer;
use PhpCsFixer\Fixer\LanguageConstruct\SingleSpaceAroundConstructFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\NewWithParenthesesFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use PhpCsFixer\Fixer\Whitespace\SpacesInsideParenthesesFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
return ECSConfig::configure()->withSkip([SingleImportPerStatementFixer::class])->withConfiguredRule(OrderedImportsFixer::class, ['imports_order' => ['class', 'function', 'const']])->withConfiguredRule(DeclareEqualNormalizeFixer::class, ['space' => 'none'])->withConfiguredRule(NoExtraBlankLinesFixer::class, ['tokens' => ['curly_brace_block']])->withConfiguredRule(VisibilityRequiredFixer::class, ['elements' => ['const', 'method', 'property']])->withConfiguredRule(MethodArgumentSpaceFixer::class, ['on_multiline' => 'ensure_fully_multiline'])->withConfiguredRule(SingleClassElementPerStatementFixer::class, ['elements' => ['property']])->withConfiguredRule(ConcatSpaceFixer::class, ['spacing' => 'one'])->withConfiguredRule(BracesPositionFixer::class, ['allow_single_line_empty_anonymous_classes' => \true])->withRules([ControlStructureBracesFixer::class, NoMultipleStatementsPerLineFixer::class, DeclareParenthesesFixer::class, ControlStructureContinuationPositionFixer::class, StatementIndentationFixer::class, SingleSpaceAroundConstructFixer::class, BinaryOperatorSpacesFixer::class, BlankLineAfterNamespaceFixer::class, BlankLineAfterOpeningTagFixer::class, ClassDefinitionFixer::class, ConstantCaseFixer::class, ElseifFixer::class, EncodingFixer::class, FullOpeningTagFixer::class, FunctionDeclarationFixer::class, IndentationTypeFixer::class, LineEndingFixer::class, LowercaseCastFixer::class, LowercaseKeywordsFixer::class, NewWithParenthesesFixer::class, NoBlankLinesAfterClassOpeningFixer::class, NoBreakCommentFixer::class, NoClosingTagFixer::class, NoExtraBlankLinesFixer::class, NoLeadingImportSlashFixer::class, NoSinglelineWhitespaceBeforeSemicolonsFixer::class, NoSpacesAfterFunctionNameFixer::class, NoTrailingWhitespaceFixer::class, NoTrailingWhitespaceInCommentFixer::class, NoWhitespaceBeforeCommaInArrayFixer::class, ReturnTypeDeclarationFixer::class, ShortScalarCastFixer::class, SingleBlankLineAtEofFixer::class, SingleImportPerStatementFixer::class, SingleLineAfterImportsFixer::class, SpacesInsideParenthesesFixer::class, SwitchCaseSemicolonToColonFixer::class, SwitchCaseSpaceFixer::class, TernaryOperatorSpacesFixer::class, UnaryOperatorSpacesFixer::class, VisibilityRequiredFixer::class, WhitespaceAfterCommaInArrayFixer::class]);
