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
namespace PhpCsFixer\FixerDefinition;

/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @readonly
 */
final class FixerDefinition implements \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
{
    /**
     * @var string
     */
    private $summary;
    /**
     * @var list<CodeSampleInterface>
     */
    private $codeSamples;
    /**
     * Description of Fixer and benefit of using it.
     * @var string|null
     */
    private $description;
    /**
     * Description why Fixer is risky.
     * @var string|null
     */
    private $riskyDescription;
    /**
     * @param list<CodeSampleInterface> $codeSamples      array of samples, where single sample is [code, configuration]
     * @param null|string               $riskyDescription null for non-risky fixer
     */
    public function __construct(string $summary, array $codeSamples, ?string $description = null, ?string $riskyDescription = null)
    {
        $this->summary = $summary;
        $this->codeSamples = $codeSamples;
        $this->description = $description;
        $this->riskyDescription = $riskyDescription;
    }
    public function getSummary() : string
    {
        return $this->summary;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function getRiskyDescription() : ?string
    {
        return $this->riskyDescription;
    }
    public function getCodeSamples() : array
    {
        return $this->codeSamples;
    }
}
