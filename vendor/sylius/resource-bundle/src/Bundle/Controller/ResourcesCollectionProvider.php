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

namespace Sylius\Bundle\ResourceBundle\Controller;

use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Pagerfanta;
use Sylius\Bundle\ResourceBundle\Grid\View\ResourceGridView;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

final class ResourcesCollectionProvider implements ResourcesCollectionProviderInterface
{
    public function __construct(
        private ResourcesResolverInterface $resourcesResolver,
        private ?PagerfantaFactory $pagerfantaRepresentationFactory = null,
    ) {
    }

    /**
     * @psalm-suppress MissingReturnType
     */
    public function get(RequestConfiguration $requestConfiguration, RepositoryInterface $repository)
    {
        $resources = $this->resourcesResolver->getResources($requestConfiguration, $repository);
        $paginationLimits = [];

        if ($resources instanceof ResourceGridView) {
            $paginator = $resources->getData();
            $paginationLimits = $resources->getDefinition()->getLimits();
        } else {
            $paginator = $resources;
        }

        if ($paginator instanceof Pagerfanta) {
            $request = $requestConfiguration->getRequest();

            $paginator->setMaxPerPage($this->resolveMaxPerPage(
                $request->query->has('limit') ? $request->query->getInt('limit') : null,
                $requestConfiguration->getPaginationMaxPerPage(),
                $paginationLimits,
            ));
            $currentPage = (int) $request->query->get('page', '1');
            $paginator->setCurrentPage($currentPage);

            // This prevents Pagerfanta from querying database from a template
            $paginator->getCurrentPageResults();

            if (!$requestConfiguration->isHtmlRequest()) {
                if (null === $this->pagerfantaRepresentationFactory) {
                    throw new \LogicException('The "willdurand/hateoas-bundle" must be installed and configured to render a resource collection on non-HTML request. Try running "composer require willdurand/hateoas-bundle"');
                }

                $route = new Route($request->attributes->get('_route'), array_merge($request->attributes->get('_route_params'), $request->query->all()));

                return $this->pagerfantaRepresentationFactory->createRepresentation($paginator, $route);
            }
        }

        return $resources;
    }

    /**
     * @param int[] $gridLimits
     */
    private function resolveMaxPerPage(?int $requestLimit, int $configurationLimit, array $gridLimits = []): int
    {
        if (null === $requestLimit) {
            return reset($gridLimits) ?: $configurationLimit;
        }

        if (!empty($gridLimits)) {
            $maxGridLimit = max($gridLimits);

            return $requestLimit > $maxGridLimit ? $maxGridLimit : $requestLimit;
        }

        return $requestLimit;
    }
}
