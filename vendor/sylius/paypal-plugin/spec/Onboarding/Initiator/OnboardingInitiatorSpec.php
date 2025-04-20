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

namespace spec\Sylius\PayPalPlugin\Onboarding\Initiator;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Payment\Model\GatewayConfigInterface;
use Sylius\PayPalPlugin\Onboarding\Initiator\OnboardingInitiatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class OnboardingInitiatorSpec extends ObjectBehavior
{
    function let(UrlGeneratorInterface $urlGenerator, Security $security): void
    {
        $this->beConstructedWith($urlGenerator, $security, 'https://paypal-url');
    }

    function it_implements_onboarding_initiator_interface(): void
    {
        $this->shouldImplement(OnboardingInitiatorInterface::class);
    }

    function it_throws_an_exception_during_initialization_if_payment_method_is_not_supported(
        PaymentMethodInterface $paymentMethod,
    ): void {
        $paymentMethod->getGatewayConfig()->willReturn(null);

        $this
            ->shouldThrow(\DomainException::class)
            ->during('initiate', [$paymentMethod])
        ;
    }

    function it_supports_paypal_payment_method_without_client_id_set(
        PaymentMethodInterface $paymentMethod,
        GatewayConfigInterface $gatewayConfig,
    ): void {
        $paymentMethod->getGatewayConfig()->willReturn($gatewayConfig);
        $gatewayConfig->getFactoryName()->willReturn('sylius_paypal');
        $gatewayConfig->getConfig()->willReturn(['some_parameter' => 'test']);

        $this->supports($paymentMethod)->shouldReturn(true);
    }

    function it_does_not_support_paypal_payment_method_with_client_id_set(
        PaymentMethodInterface $paymentMethod,
        GatewayConfigInterface $gatewayConfig,
    ): void {
        $paymentMethod->getGatewayConfig()->willReturn($gatewayConfig);
        $gatewayConfig->getFactoryName()->willReturn('sylius_paypal');
        $gatewayConfig->getConfig()->willReturn(['client_id' => '123123']);

        $this->supports($paymentMethod)->shouldReturn(false);
    }

    function it_does_not_support_payment_method_with_invalid_gateway_factory_name(
        PaymentMethodInterface $paymentMethod,
        GatewayConfigInterface $gatewayConfig,
    ): void {
        $paymentMethod->getGatewayConfig()->willReturn($gatewayConfig);
        $gatewayConfig->getFactoryName()->willReturn('offline');

        $this->supports($paymentMethod)->shouldReturn(false);
    }

    function it_does_not_support_payment_method_without_gateway_config(
        PaymentMethodInterface $paymentMethod,
    ): void {
        $paymentMethod->getGatewayConfig()->willReturn(null);

        $this->supports($paymentMethod)->shouldReturn(false);
    }

    function it_returns_url_when_payment_is_valid(
        PaymentMethodInterface $paymentMethod,
        GatewayConfigInterface $gatewayConfig,
        Security $security,
        AdminUserInterface $adminUser,
        UrlGeneratorInterface $urlGenerator,
    ): void {
        $paymentMethod->getGatewayConfig()->willReturn($gatewayConfig);

        $gatewayConfig->getFactoryName()->willReturn('sylius_paypal');
        $gatewayConfig->getConfig()->willReturn([]);

        $security->getUser()->willReturn($adminUser);
        $adminUser->getEmail()->willReturn('sylius@sylius.com');

        $urlGenerator
            ->generate('sylius_admin_payment_method_create', ['factory' => 'sylius_paypal'], UrlGeneratorInterface::ABSOLUTE_URL)
            ->willReturn('/admin/payment-methods/new/sylius_paypal')
        ;

        $this->initiate($paymentMethod)->shouldReturn(
            'https://paypal-url/partner-referrals/create?email=sylius%40sylius.com&return_url=%2Fadmin%2Fpayment-methods%2Fnew%2Fsylius_paypal',
        );
    }
}
