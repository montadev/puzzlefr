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

namespace Fidry\AliceDataFixtures\Loader;

use Fidry\AliceDataFixtures\FileResolverInterface;
use Fidry\AliceDataFixtures\LoaderInterface;
use Fidry\AliceDataFixtures\Persistence\PersisterAwareInterface;
use Fidry\AliceDataFixtures\Persistence\PersisterInterface;
use Fidry\AliceDataFixtures\Persistence\PurgeMode;
use JetBrains\PhpStorm\Pure;
use Nelmio\Alice\IsAServiceTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Decorates another loader to resolve files before loading them.
 *
 * @final
 */
/*final*/ class FileResolverLoader implements LoaderInterface, PersisterAwareInterface
{
    use IsAServiceTrait;

    private LoggerInterface $logger;

    #[Pure]
    public function __construct(
        private LoaderInterface $decoratedLoader,
        private FileResolverInterface $fileResolver,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?? new NullLogger();
    }

    public function withPersister(PersisterInterface $persister): self
    {
        $loader = $this->decoratedLoader;

        if ($loader instanceof PersisterAwareInterface) {
            $loader = $loader->withPersister($persister);
        }

        return new self($loader, $this->fileResolver, $this->logger);
    }

    /**
     * Resolves the given files before loading them.
     *
     * {@inheritdoc}
     */
    public function load(array $fixturesFiles, array $parameters = [], array $objects = [], ?PurgeMode $purgeMode = null): array
    {
        $this->logger->info('Resolving fixture files.');

        $fixturesFiles = $this->fileResolver->resolve($fixturesFiles);

        return $this->decoratedLoader->load($fixturesFiles, $parameters, $objects, $purgeMode);
    }
}
