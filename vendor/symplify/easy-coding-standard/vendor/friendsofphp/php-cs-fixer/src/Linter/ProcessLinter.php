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
namespace PhpCsFixer\Linter;

use PhpCsFixer\FileReader;
use PhpCsFixer\FileRemoval;
use ECSPrefix202503\Symfony\Component\Filesystem\Exception\IOException;
use ECSPrefix202503\Symfony\Component\Process\PhpExecutableFinder;
use ECSPrefix202503\Symfony\Component\Process\Process;
/**
 * Handle PHP code linting using separated process of `php -l _file_`.
 *
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class ProcessLinter implements \PhpCsFixer\Linter\LinterInterface
{
    /**
     * @var \PhpCsFixer\FileRemoval
     */
    private $fileRemoval;
    /**
     * @var \PhpCsFixer\Linter\ProcessLinterProcessBuilder
     */
    private $processBuilder;
    /**
     * Temporary file for code linting.
     * @var string|null
     */
    private $temporaryFile;
    /**
     * @param null|string $executable PHP executable, null for autodetection
     */
    public function __construct(?string $executable = null)
    {
        if (null === $executable) {
            $executableFinder = new PhpExecutableFinder();
            $executable = $executableFinder->find(\false);
            if (\false === $executable) {
                throw new \PhpCsFixer\Linter\UnavailableLinterException('Cannot find PHP executable.');
            }
            if ('phpdbg' === \PHP_SAPI) {
                if (\strpos($executable, 'phpdbg') === \false) {
                    throw new \PhpCsFixer\Linter\UnavailableLinterException('Automatically found PHP executable is non-standard phpdbg. Could not find proper PHP executable.');
                }
                // automatically found executable is `phpdbg`, let us try to fallback to regular `php`
                $executable = \str_replace('phpdbg', 'php', $executable);
                if (!\is_executable($executable)) {
                    throw new \PhpCsFixer\Linter\UnavailableLinterException('Automatically found PHP executable is phpdbg. Could not find proper PHP executable.');
                }
            }
        }
        $this->processBuilder = new \PhpCsFixer\Linter\ProcessLinterProcessBuilder($executable);
        $this->fileRemoval = new FileRemoval();
    }
    public function __destruct()
    {
        if (null !== $this->temporaryFile) {
            $this->fileRemoval->delete($this->temporaryFile);
        }
    }
    /**
     * This class is not intended to be serialized,
     * and cannot be deserialized (see __wakeup method).
     */
    public function __sleep() : array
    {
        throw new \BadMethodCallException('Cannot serialize ' . self::class);
    }
    /**
     * Disable the deserialization of the class to prevent attacker executing
     * code by leveraging the __destruct method.
     *
     * @see https://owasp.org/www-community/vulnerabilities/PHP_Object_Injection
     */
    public function __wakeup() : void
    {
        throw new \BadMethodCallException('Cannot unserialize ' . self::class);
    }
    public function isAsync() : bool
    {
        return \true;
    }
    public function lintFile(string $path) : \PhpCsFixer\Linter\LintingResultInterface
    {
        return new \PhpCsFixer\Linter\ProcessLintingResult($this->createProcessForFile($path), $path);
    }
    public function lintSource(string $source) : \PhpCsFixer\Linter\LintingResultInterface
    {
        return new \PhpCsFixer\Linter\ProcessLintingResult($this->createProcessForSource($source), $this->temporaryFile);
    }
    /**
     * @param string $path path to file
     */
    private function createProcessForFile(string $path) : Process
    {
        // in case php://stdin
        if (!\is_file($path)) {
            return $this->createProcessForSource(FileReader::createSingleton()->read($path));
        }
        $process = $this->processBuilder->build($path);
        $process->setTimeout(10);
        $process->start();
        return $process;
    }
    /**
     * Create process that lint PHP code.
     *
     * @param string $source code
     */
    private function createProcessForSource(string $source) : Process
    {
        if (null === $this->temporaryFile) {
            $this->temporaryFile = \tempnam(\sys_get_temp_dir(), 'cs_fixer_tmp_');
            $this->fileRemoval->observe($this->temporaryFile);
        }
        if (\false === @\file_put_contents($this->temporaryFile, $source)) {
            throw new IOException(\sprintf('Failed to write file "%s".', $this->temporaryFile), 0, null, $this->temporaryFile);
        }
        return $this->createProcessForFile($this->temporaryFile);
    }
}
