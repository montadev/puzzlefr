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

use Fidry\AliceDataFixtures\LoaderInterface;
use Fidry\AliceDataFixtures\Persistence\PersisterAwareInterface;
use Fidry\AliceDataFixtures\Persistence\PersisterInterface;
use Fidry\AliceDataFixtures\Persistence\PurgeMode;
use Fidry\AliceDataFixtures\ProcessorInterface;
use JetBrains\PhpStorm\Pure;
use Nelmio\Alice\IsAServiceTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Loader decorating another loader to add a persistence layer.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Théo FIDRY <theo.fidry@gmail.com>
 *
 * @final
 */
/*final*/ class PersisterLoader implements LoaderInterface, PersisterAwareInterface
{
    use IsAServiceTrait;

    private LoggerInterface $logger;
    private array $processors;

    /**
     * @param ProcessorInterface[] $processors
     */
    #[Pure]
    public function __construct(
        private LoaderInterface $loader,
        private PersisterInterface $persister,
        ?LoggerInterface $logger = null,
        array $processors = []
    ) {
        $this->logger = $logger ?? new NullLogger();
        $this->processors = (static fn (ProcessorInterface ...$processors) => $processors)(...$processors);
    }

    public function withPersister(PersisterInterface $persister): self
    {
        $loader = $this->loader;

        if ($loader instanceof PersisterAwareInterface) {
            $loader = $loader->withPersister($persister);
        }

        return new self($loader, $persister, $this->logger, $this->processors);
    }

    /**
     * Pre-process, persist and post process each object loaded.
     *
     * {@inheritdoc}
     */
    public function load(array $fixturesFiles, array $parameters = [], array $objects = [], ?PurgeMode $purgeMode = null): array
    {
        $objects = $this->loader->load($fixturesFiles, $parameters, $objects, $purgeMode);

        $this->logger->info('Pre-processing objects.');

        foreach ($objects as $id => $object) {
            foreach ($this->processors as $processor) {
                $processor->preProcess($id, $object);
            }

            $this->persister->persist($object);
        }

        $this->logger->info('Flushing objects.');

        $this->persister->flush();

        $this->logger->info('Post-processing objects.');

        foreach ($objects as $id => $object) {
            foreach ($this->processors as $processor) {
                $processor->postProcess($id, $object);
            }
        }

        $this->logger->info('Done.');

        return $objects;
    }
}
