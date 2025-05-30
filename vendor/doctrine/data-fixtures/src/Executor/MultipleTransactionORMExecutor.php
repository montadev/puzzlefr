<?php

declare(strict_types=1);

namespace Doctrine\Common\DataFixtures\Executor;

use Doctrine\ORM\EntityManagerInterface;

final class MultipleTransactionORMExecutor extends AbstractExecutor
{
    use ORMExecutorCommon;

    /** @inheritDoc */
    public function execute(array $fixtures, bool $append = false): void
    {
        $executor = $this;
        if ($append === false) {
            $this->em->wrapInTransaction(static fn () => $executor->purge());
        }

        foreach ($fixtures as $fixture) {
            $this->em->wrapInTransaction(static fn (EntityManagerInterface $em) => $executor->load($em, $fixture));
        }
    }
}
