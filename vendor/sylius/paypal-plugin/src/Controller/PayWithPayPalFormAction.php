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

namespace Sylius\PayPalPlugin\Controller;

use Sylius\Bundle\PayumBundle\Model\GatewayConfigInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Repository\PaymentRepositoryInterface;
use Sylius\PayPalPlugin\Api\CacheAuthorizeClientApiInterface;
use Sylius\PayPalPlugin\Api\IdentityApiInterface;
use Sylius\PayPalPlugin\Provider\AvailableCountriesProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final readonly class PayWithPayPalFormAction
{
    public function __construct(
        private Environment $twig,
        private PaymentRepositoryInterface $paymentRepository,
        private AvailableCountriesProviderInterface $countriesProvider,
        private CacheAuthorizeClientApiInterface $authorizeClientApi,
        private IdentityApiInterface $identityApi,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $paymentId = (string) $request->attributes->get('paymentId');
        $orderToken = (string) $request->attributes->get('orderToken');

        /** @var PaymentInterface $payment */
        $payment = $this->paymentRepository->findOneByOrderToken($paymentId, $orderToken);
        /** @var PaymentMethodInterface $paymentMethod */
        $paymentMethod = $payment->getMethod();

        /** @var GatewayConfigInterface $gatewayConfig */
        $gatewayConfig = $paymentMethod->getGatewayConfig();
        /** @var string $clientId */
        $clientId = $gatewayConfig->getConfig()['client_id'];
        /** @var string $partnerAttributionId */
        $partnerAttributionId = $gatewayConfig->getConfig()['partner_attribution_id'];

        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        $token = $this->authorizeClientApi->authorize($paymentMethod);
        $clientToken = $this->identityApi->generateToken($token);

        return new Response($this->twig->render('@SyliusPayPalPlugin/pay_with_paypal.html.twig', [
            'available_countries' => $this->countriesProvider->provide(),
            'billing_address' => $order->getBillingAddress(),
            'client_id' => $clientId,
            'client_token' => $clientToken,
            'currency' => $order->getCurrencyCode(),
            'locale' => $request->getLocale(),
            'merchant_id' => $gatewayConfig->getConfig()['merchant_id'],
            'order_token' => $order->getTokenValue(),
            'partner_attribution_id' => $partnerAttributionId,
        ]));
    }
}
