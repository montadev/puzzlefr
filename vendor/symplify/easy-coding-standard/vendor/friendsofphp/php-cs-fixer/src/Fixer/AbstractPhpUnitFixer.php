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
namespace PhpCsFixer\Fixer;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\DocBlock\DocBlock;
use PhpCsFixer\DocBlock\Line;
use PhpCsFixer\Indicator\PhpUnitTestCaseIndicator;
use PhpCsFixer\Tokenizer\Analyzer\Analysis\NamespaceUseAnalysis;
use PhpCsFixer\Tokenizer\Analyzer\AttributeAnalyzer;
use PhpCsFixer\Tokenizer\Analyzer\FullyQualifiedNameAnalyzer;
use PhpCsFixer\Tokenizer\Analyzer\FunctionsAnalyzer;
use PhpCsFixer\Tokenizer\Analyzer\WhitespacesAnalyzer;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @internal
 */
abstract class AbstractPhpUnitFixer extends AbstractFixer
{
    public function isCandidate(Tokens $tokens) : bool
    {
        return $tokens->isAllTokenKindsFound([\T_CLASS, \T_STRING]);
    }
    protected final function applyFix(\SplFileInfo $file, Tokens $tokens) : void
    {
        $phpUnitTestCaseIndicator = new PhpUnitTestCaseIndicator();
        foreach ($phpUnitTestCaseIndicator->findPhpUnitClasses($tokens) as $indices) {
            $this->applyPhpUnitClassFix($tokens, $indices[0], $indices[1]);
        }
    }
    protected abstract function applyPhpUnitClassFix(Tokens $tokens, int $startIndex, int $endIndex) : void;
    protected final function getDocBlockIndex(Tokens $tokens, int $index) : int
    {
        $modifiers = [\T_PUBLIC, \T_PROTECTED, \T_PRIVATE, \T_FINAL, \T_ABSTRACT, \T_COMMENT];
        if (\defined('T_ATTRIBUTE')) {
            // @TODO: drop condition when PHP 8.0+ is required
            $modifiers[] = \T_ATTRIBUTE;
        }
        if (\defined('T_READONLY')) {
            // @TODO: drop condition when PHP 8.2+ is required
            $modifiers[] = \T_READONLY;
        }
        do {
            $index = $tokens->getPrevNonWhitespace($index);
            if ($tokens[$index]->isGivenKind(CT::T_ATTRIBUTE_CLOSE)) {
                $index = $tokens->getPrevTokenOfKind($index, [[\T_ATTRIBUTE]]);
            }
        } while ($tokens[$index]->isGivenKind($modifiers));
        return $index;
    }
    /**
     * @param list<string>       $preventingAnnotations
     * @param list<class-string> $preventingAttributes
     */
    protected final function ensureIsDocBlockWithAnnotation(Tokens $tokens, int $index, string $annotation, array $preventingAnnotations, array $preventingAttributes) : void
    {
        $docBlockIndex = $this->getDocBlockIndex($tokens, $index);
        if (self::isPreventedByAttribute($tokens, $index, $preventingAttributes)) {
            return;
        }
        if ($this->isPHPDoc($tokens, $docBlockIndex)) {
            $this->updateDocBlockIfNeeded($tokens, $docBlockIndex, $annotation, $preventingAnnotations);
        } else {
            $this->createDocBlock($tokens, $docBlockIndex, $annotation);
        }
    }
    protected final function isPHPDoc(Tokens $tokens, int $index) : bool
    {
        return $tokens[$index]->isGivenKind(\T_DOC_COMMENT);
    }
    /**
     * @return iterable<array{
     *     index: int,
     *     loweredName: string,
     *     openBraceIndex: int,
     *     closeBraceIndex: int,
     * }>
     */
    protected function getPreviousAssertCall(Tokens $tokens, int $startIndex, int $endIndex) : iterable
    {
        $functionsAnalyzer = new FunctionsAnalyzer();
        for ($index = $endIndex; $index > $startIndex; --$index) {
            $index = $tokens->getPrevTokenOfKind($index, [[\T_STRING]]);
            if (null === $index) {
                return;
            }
            // test if "assert" something call
            $loweredContent = \strtolower($tokens[$index]->getContent());
            if (\strncmp($loweredContent, 'assert', \strlen('assert')) !== 0) {
                continue;
            }
            // test candidate for simple calls like: ([\]+'some fixable call'(...))
            $openBraceIndex = $tokens->getNextMeaningfulToken($index);
            if (!$tokens[$openBraceIndex]->equals('(')) {
                continue;
            }
            if (!$functionsAnalyzer->isTheSameClassCall($tokens, $index)) {
                continue;
            }
            (yield ['index' => $index, 'loweredName' => $loweredContent, 'openBraceIndex' => $openBraceIndex, 'closeBraceIndex' => $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openBraceIndex)]);
        }
    }
    protected final function isTestAttributePresent(Tokens $tokens, int $index) : bool
    {
        $prevMethodEndIndex = $tokens->getPrevTokenOfKind($index, ['}']);
        $currentIndex = $index - 1;
        while (\true) {
            $attributeIndex = $tokens->getPrevTokenOfKind($currentIndex, [[\T_ATTRIBUTE]]);
            if (null === $attributeIndex || $attributeIndex <= $prevMethodEndIndex) {
                break;
            }
            $fullyQualifiedNameAnalyzer = new FullyQualifiedNameAnalyzer($tokens);
            foreach (AttributeAnalyzer::collect($tokens, $attributeIndex) as $attributeAnalysis) {
                foreach ($attributeAnalysis->getAttributes() as $attribute) {
                    $attributeName = \strtolower($fullyQualifiedNameAnalyzer->getFullyQualifiedName($attribute['name'], $attribute['start'], NamespaceUseAnalysis::TYPE_CLASS));
                    if ('phpunit\\framework\\attributes\\test' === $attributeName) {
                        return \true;
                    }
                }
            }
            $currentIndex = $attributeIndex - 1;
        }
        return \false;
    }
    private function createDocBlock(Tokens $tokens, int $docBlockIndex, string $annotation) : void
    {
        $lineEnd = $this->whitespacesConfig->getLineEnding();
        $originalIndent = WhitespacesAnalyzer::detectIndent($tokens, $tokens->getNextNonWhitespace($docBlockIndex));
        $toInsert = [new Token([\T_DOC_COMMENT, "/**{$lineEnd}{$originalIndent} * @{$annotation}{$lineEnd}{$originalIndent} */"]), new Token([\T_WHITESPACE, $lineEnd . $originalIndent])];
        $index = $tokens->getNextMeaningfulToken($docBlockIndex);
        $tokens->insertAt($index, $toInsert);
        if (!$tokens[$index - 1]->isGivenKind(\T_WHITESPACE)) {
            $extraNewLines = $this->whitespacesConfig->getLineEnding();
            if (!$tokens[$index - 1]->isGivenKind(\T_OPEN_TAG)) {
                $extraNewLines .= $this->whitespacesConfig->getLineEnding();
            }
            $tokens->insertAt($index, [new Token([\T_WHITESPACE, $extraNewLines . WhitespacesAnalyzer::detectIndent($tokens, $index)])]);
        }
    }
    /**
     * @param list<string> $preventingAnnotations
     */
    private function updateDocBlockIfNeeded(Tokens $tokens, int $docBlockIndex, string $annotation, array $preventingAnnotations) : void
    {
        $doc = new DocBlock($tokens[$docBlockIndex]->getContent());
        foreach ($preventingAnnotations as $preventingAnnotation) {
            if ([] !== $doc->getAnnotationsOfType($preventingAnnotation)) {
                return;
            }
        }
        $doc = $this->makeDocBlockMultiLineIfNeeded($doc, $tokens, $docBlockIndex, $annotation);
        $lines = $this->addInternalAnnotation($doc, $tokens, $docBlockIndex, $annotation);
        $lines = \implode('', $lines);
        $tokens->getNamespaceDeclarations();
        $tokens[$docBlockIndex] = new Token([\T_DOC_COMMENT, $lines]);
    }
    /**
     * @param list<class-string> $preventingAttributes
     */
    private static function isPreventedByAttribute(Tokens $tokens, int $index, array $preventingAttributes) : bool
    {
        if ([] === $preventingAttributes) {
            return \false;
        }
        $modifiers = [\T_FINAL];
        if (\defined('T_READONLY')) {
            // @TODO: drop condition when PHP 8.2+ is required
            $modifiers[] = \T_READONLY;
        }
        do {
            $index = $tokens->getPrevMeaningfulToken($index);
        } while ($tokens[$index]->isGivenKind($modifiers));
        if (!$tokens[$index]->isGivenKind(CT::T_ATTRIBUTE_CLOSE)) {
            return \false;
        }
        $index = $tokens->findBlockStart(Tokens::BLOCK_TYPE_ATTRIBUTE, $index);
        $fullyQualifiedNameAnalyzer = new FullyQualifiedNameAnalyzer($tokens);
        foreach (AttributeAnalyzer::collect($tokens, $index) as $attributeAnalysis) {
            foreach ($attributeAnalysis->getAttributes() as $attribute) {
                if (\in_array(\strtolower($fullyQualifiedNameAnalyzer->getFullyQualifiedName($attribute['name'], $attribute['start'], NamespaceUseAnalysis::TYPE_CLASS)), $preventingAttributes, \true)) {
                    return \true;
                }
            }
        }
        return \false;
    }
    /**
     * @return list<Line>
     */
    private function addInternalAnnotation(DocBlock $docBlock, Tokens $tokens, int $docBlockIndex, string $annotation) : array
    {
        $lines = $docBlock->getLines();
        $originalIndent = WhitespacesAnalyzer::detectIndent($tokens, $docBlockIndex);
        $lineEnd = $this->whitespacesConfig->getLineEnding();
        \array_splice($lines, -1, 0, $originalIndent . ' * @' . $annotation . $lineEnd);
        return $lines;
    }
    private function makeDocBlockMultiLineIfNeeded(DocBlock $doc, Tokens $tokens, int $docBlockIndex, string $annotation) : DocBlock
    {
        $lines = $doc->getLines();
        if (1 === \count($lines) && [] === $doc->getAnnotationsOfType($annotation)) {
            $indent = WhitespacesAnalyzer::detectIndent($tokens, $tokens->getNextNonWhitespace($docBlockIndex));
            $doc->makeMultiLine($indent, $this->whitespacesConfig->getLineEnding());
            return $doc;
        }
        return $doc;
    }
}
