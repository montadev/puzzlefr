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

namespace Sylius\Bundle\AdminBundle\Twig\Component\Order;

use Sylius\Component\Addressing\Model\AddressLogEntry;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\TwigHooks\Twig\Component\HookableComponentTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

class AddressHistoryComponent
{
    use HookableComponentTrait;

    public ?string $addressId = null;

    public ?string $header = null;

    public ?string $sort = 'desc';

    /** @param RepositoryInterface<AddressLogEntry> $addressLogRepository */
    public function __construct(
        protected readonly RepositoryInterface $addressLogRepository,
    ) {
    }

    /** @return AddressLogEntry[] */
    #[ExposeInTemplate(name: 'address_logs')]
    public function getAddressLogs(): array
    {
        return $this->addressLogRepository->findBy(
            ['objectId' => $this->addressId],
            ['loggedAt' => $this->sort],
        );
    }
}
