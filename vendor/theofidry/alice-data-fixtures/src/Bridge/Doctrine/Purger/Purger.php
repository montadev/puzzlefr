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

namespace Fidry\AliceDataFixtures\Bridge\Doctrine\Purger;

use Doctrine\Common\DataFixtures\Purger\MongoDBPurger as DoctrineMongoDBPurger;
use Doctrine\Common\DataFixtures\Purger\ORMPurger as DoctrineOrmPurger;
use Doctrine\Common\DataFixtures\Purger\PHPCRPurger as DoctrinePhpCrPurger;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface as DoctrinePurgerInterface;
use Doctrine\DBAL\Platforms\MariaDBPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ODM\MongoDB\DocumentManager as DoctrineMongoDocumentManager;
use Doctrine\ODM\PHPCR\DocumentManager as DoctrinePhpCrDocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Fidry\AliceDataFixtures\Persistence\PurgeMode;
use Fidry\AliceDataFixtures\Persistence\PurgerFactoryInterface;
use Fidry\AliceDataFixtures\Persistence\PurgerInterface;
use InvalidArgumentException;
use Nelmio\Alice\IsAServiceTrait;

/**
 * Bridge for Doctrine purger.
 *
 * @author Vincent CHALAMON <vincentchalamon@gmail.com>
 *
 * @final
 */
/* final */ class Purger implements PurgerInterface, PurgerFactoryInterface
{
    use IsAServiceTrait;

    private DoctrinePurgerInterface $purger;

    public function __construct(
        private ObjectManager $manager,
        private ?PurgeMode $purgeMode = null,
    ) {
        $this->purger = static::createPurger($manager, $this->purgeMode);
    }

    public function create(PurgeMode $mode, ?PurgerInterface $purger = null): PurgerInterface
    {
        if (null === $purger) {
            return new self($this->manager, $mode);
        }

        if ($purger instanceof DoctrinePurgerInterface) {
            $manager = $purger->getObjectManager();
        } elseif ($purger instanceof self) {
            $manager = $purger->manager;
        } else {
            throw new InvalidArgumentException(
                sprintf(
                    'Expected purger to be either and instance of "%s" or "%s". Got "%s".',
                    DoctrinePurgerInterface::class,
                    self::class,
                    $purger::class
                )
            );
        }

        if (null === $manager) {
            throw new InvalidArgumentException(
                sprintf(
                    'Expected purger "%s" to have an object manager, got "null" instead.',
                    $purger::class
                )
            );
        }

        return new self($manager, $mode);
    }

    public function purge(): void
    {
        // Because MySQL rocks, you got to disable foreign key checks when doing a TRUNCATE/DELETE unlike in for example
        // PostgreSQL. This ideally should be done in the Purger of doctrine/data-fixtures but meanwhile we are doing
        // it here.
        // See the progress in https://github.com/doctrine/data-fixtures/pull/272
        $disableFkChecks = (
            $this->purger instanceof DoctrineOrmPurger
            && in_array($this->purgeMode->getValue(), [PurgeMode::createDeleteMode()->getValue(), PurgeMode::createTruncateMode()->getValue()])
            && $this->doesDatabaseSupportTruncate()
        );

        if ($disableFkChecks) {
            $connection = $this->purger->getObjectManager()->getConnection();

            $connection->executeStatement('SET FOREIGN_KEY_CHECKS = 0;');
        }

        $this->purger->purge();

        if ($disableFkChecks && isset($connection)) {
            $connection->executeStatement('SET FOREIGN_KEY_CHECKS = 1;');
        }
    }

    private static function createPurger(ObjectManager $manager, ?PurgeMode $purgeMode): DoctrinePurgerInterface
    {
        if ($manager instanceof EntityManagerInterface) {
            $purger = new DoctrineOrmPurger($manager);

            if (null !== $purgeMode) {
                $purger->setPurgeMode($purgeMode->getValue());
            }

            return $purger;
        }

        if ($manager instanceof DoctrinePhpCrDocumentManager) {
            return new DoctrinePhpCrPurger($manager);
        }

        if ($manager instanceof DoctrineMongoDocumentManager) {
            return new DoctrineMongoDBPurger($manager);
        }

        throw new InvalidArgumentException(
            sprintf(
                'Cannot create a purger for ObjectManager of class %s',
                $manager::class
            )
        );
    }

    private function doesDatabaseSupportTruncate(): bool
    {
        $platform = $this->purger->getObjectManager()->getConnection()->getDatabasePlatform();

        return $platform instanceof MySqlPlatform
            || $platform instanceof MariaDBPlatform;
    }
}
