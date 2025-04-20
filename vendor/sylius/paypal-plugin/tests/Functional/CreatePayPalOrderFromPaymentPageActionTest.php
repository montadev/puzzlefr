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

final class CreatePayPalOrderFromPaymentPageActionTest extends JsonApiTestCase
{
    /** @test */
    public function it_creates_paypal_order_from_payment_page_and_returns_its_data(): void
    {
        $order = $this->loadFixturesFromFiles(['resources/shop.yaml', 'resources/new_cart.yaml']);
        /** @var int $orderId */
        $orderId = $order['new_cart']->getId();

        $this->client->request('POST', '/en_US/pay-pal-order-payment-page/' . $orderId . '/create');

        $response = $this->client->getResponse();
        $content = (array) json_decode($response->getContent(), true);

        $this->assertSame($content['order_id'], 'PAYPAL_ORDER_ID');
    }
}
