<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ResourceBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Sylius\Resource\Metadata\MetadataInterface;
use Sylius\Resource\Metadata\RegistryInterface;
use Sylius\Resource\Model\TranslatableInterface;
use Sylius\Resource\Model\TranslationInterface;
use Sylius\Resource\Translation\TranslatableEntityLocaleAssignerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ORMTranslatableListener implements EventSubscriber
{
    private RegistryInterface $resourceMetadataRegistry;

    private TranslatableEntityLocaleAssignerInterface $translatableEntityLocaleAssigner;

    public function __construct(
        RegistryInterface $resourceMetadataRegistry,
        object $translatableEntityLocaleAssigner,
    ) {
        $this->resourceMetadataRegistry = $resourceMetadataRegistry;
        $this->translatableEntityLocaleAssigner = $this->processTranslatableEntityLocaleAssigner($translatableEntityLocaleAssigner);
    }

    /**
     * @deprecated since version 1.10, It will be removed in 2.0.
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
            Events::postLoad,
        ];
    }

    /**
     * Add mapping to translatable entities
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $reflection = $classMetadata->getReflectionClass();

        if ($reflection->isAbstract()) {
            return;
        }

        if ($reflection->implementsInterface(TranslatableInterface::class)) {
            $this->mapTranslatable($classMetadata);
        }

        if ($reflection->implementsInterface(TranslationInterface::class)) {
            $this->mapTranslation($classMetadata);
        }
    }

    public function postLoad(PostLoadEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof TranslatableInterface) {
            return;
        }

        $this->translatableEntityLocaleAssigner->assignLocale($entity);
    }

    /**
     * Add mapping data to a translatable entity.
     */
    private function mapTranslatable(ClassMetadata $metadata): void
    {
        $className = $metadata->name;

        try {
            $resourceMetadata = $this->resourceMetadataRegistry->getByClass($className);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        if (!$resourceMetadata->hasParameter('translation')) {
            return;
        }

        /** @var MetadataInterface $translationResourceMetadata */
        $translationResourceMetadata = $this->resourceMetadataRegistry->get($resourceMetadata->getAlias() . '_translation');

        if (!$metadata->hasAssociation('translations')) {
            $metadata->mapOneToMany([
                'fieldName' => 'translations',
                'targetEntity' => $translationResourceMetadata->getClass('model'),
                'mappedBy' => 'translatable',
                'fetch' => ClassMetadata::FETCH_EXTRA_LAZY,
                'indexBy' => 'locale',
                'cascade' => ['persist', 'merge', 'remove'],
                'orphanRemoval' => true,
            ]);
        }
    }

    /**
     * Add mapping data to a translation entity.
     */
    private function mapTranslation(ClassMetadata $metadata): void
    {
        $className = $metadata->name;

        try {
            $resourceMetadata = $this->resourceMetadataRegistry->getByClass($className);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        /** @var MetadataInterface $translatableResourceMetadata */
        $translatableResourceMetadata = $this->resourceMetadataRegistry->get(str_replace('_translation', '', $resourceMetadata->getAlias()));

        if (!$metadata->hasAssociation('translatable')) {
            $metadata->mapManyToOne([
                'fieldName' => 'translatable',
                'targetEntity' => $translatableResourceMetadata->getClass('model'),
                'inversedBy' => 'translations',
                'joinColumns' => [[
                    'name' => 'translatable_id',
                    'referencedColumnName' => 'id',
                    'onDelete' => 'CASCADE',
                    'nullable' => false,
                ]],
            ]);
        }

        if (!$metadata->hasField('locale')) {
            $metadata->mapField([
                'fieldName' => 'locale',
                'type' => 'string',
                'nullable' => false,
            ]);
        }

        // Map unique index.
        $columns = [
            $metadata->getSingleAssociationJoinColumnName('translatable'),
            'locale',
        ];

        if (!$this->hasUniqueConstraint($metadata, $columns)) {
            $constraints = $metadata->table['uniqueConstraints'] ?? [];

            $constraints[$metadata->getTableName() . '_uniq_trans'] = [
                'columns' => $columns,
            ];

            $metadata->setPrimaryTable([
                'uniqueConstraints' => $constraints,
            ]);
        }
    }

    /**
     * Check if a unique constraint has been defined.
     */
    private function hasUniqueConstraint(ClassMetadata $metadata, array $columns): bool
    {
        if (!isset($metadata->table['uniqueConstraints'])) {
            return false;
        }

        foreach ($metadata->table['uniqueConstraints'] as $constraint) {
            if (!array_diff($constraint['columns'], $columns)) {
                return true;
            }
        }

        return false;
    }

    private function processTranslatableEntityLocaleAssigner(object $translatableEntityLocaleAssigner): TranslatableEntityLocaleAssignerInterface
    {
        if ($translatableEntityLocaleAssigner instanceof ContainerInterface) {
            trigger_deprecation(
                'sylius/resource-bundle',
                '1.4',
                'Passing an instance of "%s" is deprecated. Use "%s" instead.',
                ContainerInterface::class,
                TranslatableEntityLocaleAssignerInterface::class,
            );

            /** @var object $translatableEntityLocaleAssigner */
            $translatableEntityLocaleAssigner = $translatableEntityLocaleAssigner->get('sylius.translatable_entity_locale_assigner');
        }

        if (!$translatableEntityLocaleAssigner instanceof TranslatableEntityLocaleAssignerInterface) {
            throw new \InvalidArgumentException(sprintf(
                '`$translatableEntityLocaleAssigner` was expected to return an instance of "%s" , "%s" found',
                TranslatableEntityLocaleAssignerInterface::class,
                get_class($translatableEntityLocaleAssigner),
            ));
        }

        return $translatableEntityLocaleAssigner;
    }
}
