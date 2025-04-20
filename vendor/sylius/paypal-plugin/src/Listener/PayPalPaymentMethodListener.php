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

namespace Sylius\PayPalPlugin\Listener;

use Payum\Core\Model\GatewayConfigInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\PayPalPlugin\DependencyInjection\SyliusPayPalExtension;
use Sylius\PayPalPlugin\Exception\PayPalPaymentMethodNotFoundException;
use Sylius\PayPalPlugin\Onboarding\Initiator\OnboardingInitiatorInterface;
use Sylius\PayPalPlugin\Provider\FlashBagProvider;
use Sylius\PayPalPlugin\Provider\PayPalPaymentMethodProviderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webmozart\Assert\Assert;

final readonly class PayPalPaymentMethodListener
{
    public function __construct(
        private OnboardingInitiatorInterface $onboardingInitiator,
        private UrlGeneratorInterface $urlGenerator,
        private RequestStack $flashBagOrRequestStack,
        private PayPalPaymentMethodProviderInterface $payPalPaymentMethodProvider,
    ) {
    }

    public function initializeCreate(ResourceControllerEvent $event): void
    {
        /** @var object $paymentMethod */
        $paymentMethod = $event->getSubject();
        /** @var PaymentMethodInterface $paymentMethod */
        Assert::isInstanceOf($paymentMethod, PaymentMethodInterface::class);

        if (!$this->isNewPaymentMethodPayPal($paymentMethod)) {
            return;
        }

        if ($this->isTherePayPalPaymentMethod()) {
            FlashBagProvider::getFlashBag($this->flashBagOrRequestStack)
                ->add('error', 'sylius_paypal.more_than_one_seller_not_allowed')
            ;

            $event->setResponse(new RedirectResponse($this->urlGenerator->generate('sylius_admin_payment_method_index')));

            return;
        }

        if (!$this->onboardingInitiator->supports($paymentMethod)) {
            return;
        }

        $event->setResponse(new RedirectResponse($this->onboardingInitiator->initiate($paymentMethod)));
    }

    private function isNewPaymentMethodPayPal(PaymentMethodInterface $paymentMethod): bool
    {
        /** @var GatewayConfigInterface $gatewayConfig */
        $gatewayConfig = $paymentMethod->getGatewayConfig();

        return $gatewayConfig->getFactoryName() === SyliusPayPalExtension::PAYPAL_FACTORY_NAME;
    }

    private function isTherePayPalPaymentMethod(): bool
    {
        try {
            $this->payPalPaymentMethodProvider->provide();
        } catch (PayPalPaymentMethodNotFoundException $exception) {
            return false;
        }

        return true;
    }
}
