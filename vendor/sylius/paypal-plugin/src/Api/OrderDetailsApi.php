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

namespace Sylius\PayPalPlugin\Api;

use Sylius\PayPalPlugin\Client\PayPalClientInterface;

final readonly class OrderDetailsApi implements OrderDetailsApiInterface
{
    public function __construct(private PayPalClientInterface $client)
    {
    }

    public function get(string $token, string $orderId): array
    {
        return $this->client->get(sprintf('v2/checkout/orders/%s', $orderId), $token);
    }
}
