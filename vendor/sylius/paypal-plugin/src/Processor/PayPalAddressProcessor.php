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

namespace Sylius\PayPalPlugin\Processor;

use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\OrderInterface;
use Webmozart\Assert\Assert;

trigger_deprecation(
    'sylius/paypal-plugin',
    '1.7',
    'The "%s" class is deprecated and will be removed in Sylius/PayPalPlugin 3.0.',
    PayPalAddressProcessor::class,
);

/** @deprecated since Sylius/PayPalPlugin 1.7 and will be removed in Sylius/PayPalPlugin 3.0. */
final readonly class PayPalAddressProcessor implements PayPalAddressProcessorInterface
{
    public function __construct(private ObjectManager $objectManager)
    {
    }

    /**
     * @param array<string, string> $address
     */
    public function process(array $address, OrderInterface $order): void
    {
        $orderAddress = $order->getShippingAddress();

        if (null === $orderAddress) {
            return;
        }

        Assert::keyExists($address, 'admin_area_2');
        Assert::keyExists($address, 'address_line_1');
        Assert::keyExists($address, 'postal_code');
        Assert::keyExists($address, 'country_code');

        $street = $address['address_line_1'] . (isset($address['address_line_2']) ? ' ' . $address['address_line_2'] : '');

        $orderAddress->setCity($address['admin_area_2']);
        $orderAddress->setStreet($street);
        $orderAddress->setPostcode($address['postal_code']);
        $orderAddress->setCountryCode($address['country_code']);

        $this->objectManager->flush();
    }
}
