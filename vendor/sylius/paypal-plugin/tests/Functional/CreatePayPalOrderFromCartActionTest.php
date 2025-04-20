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

namespace Tests\Sylius\PayPalPlugin\Functional;

use ApiTestCase\JsonApiTestCase;

final class CreatePayPalOrderFromCartActionTest extends JsonApiTestCase
{
    /** @test */
    public function it_creates_paypal_order_from_cart_and_returns_its_data(): void
    {
        $order = $this->loadFixturesFromFiles(['resources/shop.yaml', 'resources/new_cart.yaml']);
        /** @var int $orderId */
        $orderId = $order['new_cart']->getId();

        $this->client->request('POST', '/en_US/create-pay-pal-order-from-cart/' . $orderId);

        $response = $this->client->getResponse();
        $content = (array) json_decode($response->getContent(), true);

        $this->assertSame($content['id'], $orderId);
        $this->assertSame($content['orderID'], 'PAYPAL_ORDER_ID');
        $this->assertSame($content['status'], 'cart');
    }

    /** @test */
    public function it_creates_pay_pal_order_from_cart_and_returns_its_data_if_payment_method_is_different_then_pay_pal(): void
    {
        $order = $this->loadFixturesFromFiles(['resources/shop.yaml', 'resources/new_cart_with_cash_on_delivery_method.yaml']);
        /** @var int $orderId */
        $orderId = $order['new_cart']->getId();

        $this->client->request('POST', '/en_US/create-pay-pal-order-from-cart/' . $orderId);

        $response = $this->client->getResponse();
        $content = (array) json_decode($response->getContent(), true);

        $this->assertSame($content['id'], $orderId);
        $this->assertSame($content['orderID'], 'PAYPAL_ORDER_ID');
        $this->assertSame($content['status'], 'cart');
    }
}
