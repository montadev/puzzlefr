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

use GuzzleHttp\Exception\ClientException;
use Sylius\Bundle\PayumBundle\Model\GatewayConfigInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\PayPalPlugin\Api\CacheAuthorizeClientApiInterface;
use Sylius\PayPalPlugin\Api\OrderDetailsApiInterface;
use Sylius\PayPalPlugin\Api\RefundPaymentApiInterface;
use Sylius\PayPalPlugin\DependencyInjection\SyliusPayPalExtension;
use Sylius\PayPalPlugin\Exception\PayPalOrderRefundException;
use Sylius\PayPalPlugin\Generator\PayPalAuthAssertionGeneratorInterface;
use Sylius\PayPalPlugin\Provider\RefundReferenceNumberProviderInterface;

final readonly class PayPalPaymentRefundProcessor implements PaymentRefundProcessorInterface
{
    public function __construct(
        private CacheAuthorizeClientApiInterface $authorizeClientApi,
        private OrderDetailsApiInterface $orderDetailsApi,
        private RefundPaymentApiInterface $refundOrderApi,
        private PayPalAuthAssertionGeneratorInterface $payPalAuthAssertionGenerator,
        private RefundReferenceNumberProviderInterface $refundReferenceNumberProvider,
    ) {
    }

    public function refund(PaymentInterface $payment): void
    {
        /** @var PaymentMethodInterface $paymentMethod */
        $paymentMethod = $payment->getMethod();
        /** @var GatewayConfigInterface $gatewayConfig */
        $gatewayConfig = $paymentMethod->getGatewayConfig();

        if ($gatewayConfig->getFactoryName() !== SyliusPayPalExtension::PAYPAL_FACTORY_NAME) {
            return;
        }

        $details = $payment->getDetails();
        if (!isset($details['paypal_order_id'])) {
            return;
        }

        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        try {
            $token = $this->authorizeClientApi->authorize($paymentMethod);
            $details = $this->orderDetailsApi->get($token, (string) $details['paypal_order_id']);
            $authAssertion = $this->payPalAuthAssertionGenerator->generate($paymentMethod);
            $referenceNumber = $this->refundReferenceNumberProvider->provide($payment);
            $payPalPaymentId = (string) $details['purchase_units'][0]['payments']['captures'][0]['id'];

            $this->refundOrderApi->refund(
                $token,
                $payPalPaymentId,
                $authAssertion,
                $referenceNumber,
                (string) (((int) $payment->getAmount()) / 100),
                (string) $order->getCurrencyCode(),
            );
        } catch (ClientException | \InvalidArgumentException $exception) {
            throw new PayPalOrderRefundException();
        }
    }
}
