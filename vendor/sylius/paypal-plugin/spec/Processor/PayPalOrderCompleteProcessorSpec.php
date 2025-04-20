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

namespace spec\Sylius\PayPalPlugin\Processor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Payment\Model\GatewayConfigInterface;
use Sylius\PayPalPlugin\Manager\PaymentStateManagerInterface;
use Sylius\PayPalPlugin\Verifier\PaymentAmountVerifierInterface;

final class PayPalOrderCompleteProcessorSpec extends ObjectBehavior
{
    function let(
        PaymentStateManagerInterface $paymentStateManager,
        PaymentAmountVerifierInterface $paymentAmountVerifier,
    ): void {
        $this->beConstructedWith($paymentStateManager, $paymentAmountVerifier);
    }

    function it_completes_paypal_order(
        PaymentStateManagerInterface $paymentStateManager,
        OrderInterface $order,
        PaymentInterface $payment,
        PaymentMethodInterface $paymentMethod,
        GatewayConfigInterface $gatewayConfig,
        PaymentAmountVerifierInterface $paymentAmountVerifier,
    ): void {
        $order->getLastPayment(PaymentInterface::STATE_PROCESSING)->willReturn($payment);

        $payment->getMethod()->willReturn($paymentMethod);
        $paymentMethod->getGatewayConfig()->willReturn($gatewayConfig);
        $gatewayConfig->getFactoryName()->willReturn('sylius_paypal');
        $paymentAmountVerifier->verify($payment)->shouldBeCalled();

        $paymentStateManager->complete($payment)->shouldBeCalled();

        $this->completePayPalOrder($order);
    }

    function it_does_nothing_if_processing_payment_is_not_paypal(
        PaymentStateManagerInterface $paymentStateManager,
        OrderInterface $order,
        PaymentInterface $payment,
        PaymentMethodInterface $paymentMethod,
        GatewayConfigInterface $gatewayConfig,
    ): void {
        $order->getLastPayment(PaymentInterface::STATE_PROCESSING)->willReturn($payment);

        $payment->getMethod()->willReturn($paymentMethod);
        $paymentMethod->getGatewayConfig()->willReturn($gatewayConfig);
        $gatewayConfig->getFactoryName()->willReturn('stripe');

        $paymentStateManager->complete($payment)->shouldNotBeCalled();

        $this->completePayPalOrder($order);
    }

    function it_does_nothing_if_there_is_no_processing_payment_for_the_order(
        PaymentStateManagerInterface $paymentStateManager,
        OrderInterface $order,
    ): void {
        $order->getLastPayment(PaymentInterface::STATE_PROCESSING)->willReturn(null);

        $paymentStateManager->complete(Argument::any())->shouldNotBeCalled();

        $this->completePayPalOrder($order);
    }
}
