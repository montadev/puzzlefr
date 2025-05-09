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

namespace Sylius\PayPalPlugin\Resolver;

use Sylius\Bundle\PayumBundle\Model\GatewayConfigInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface as CorePaymentMethodInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Sylius\Component\Payment\Exception\UnresolvedDefaultPaymentMethodException;
use Sylius\Component\Payment\Model\PaymentInterface as BasePaymentInterface;
use Sylius\Component\Payment\Model\PaymentMethodInterface;
use Sylius\Component\Payment\Resolver\DefaultPaymentMethodResolverInterface;
use Sylius\PayPalPlugin\DependencyInjection\SyliusPayPalExtension;
use Webmozart\Assert\Assert;

final readonly class PayPalDefaultPaymentMethodResolver implements DefaultPaymentMethodResolverInterface
{
    public function __construct(
        private DefaultPaymentMethodResolverInterface $decoratedDefaultPaymentMethodResolver,
        private PaymentMethodRepositoryInterface $paymentMethodRepository,
    ) {
    }

    public function getDefaultPaymentMethod(BasePaymentInterface $payment, string $prioritisedPayment = SyliusPayPalExtension::PAYPAL_FACTORY_NAME): PaymentMethodInterface
    {
        /** @var PaymentInterface $payment */
        Assert::isInstanceOf($payment, PaymentInterface::class);

        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        /** @var ChannelInterface $channel */
        $channel = $order->getChannel();

        return $this->getFirstPrioritisedPaymentForChannel($channel, $prioritisedPayment);
    }

    private function getFirstPrioritisedPaymentForChannel(ChannelInterface $channel, string $prioritisedPayment): PaymentMethodInterface
    {
        /** @var array<CorePaymentMethodInterface> $paymentMethods */
        $paymentMethods = $this->paymentMethodRepository->findEnabledForChannel($channel);

        if (empty($paymentMethods)) {
            throw new UnresolvedDefaultPaymentMethodException();
        }

        foreach ($paymentMethods as $paymentMethod) {
            /** @var GatewayConfigInterface $gatewayConfig */
            $gatewayConfig = $paymentMethod->getGatewayConfig();

            if ($gatewayConfig->getFactoryName() === $prioritisedPayment) {
                return $paymentMethod;
            }
        }

        return $paymentMethods[0];
    }
}
