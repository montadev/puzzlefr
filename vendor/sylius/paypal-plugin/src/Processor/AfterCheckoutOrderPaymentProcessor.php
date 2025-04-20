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

use Sylius\Component\Core\Model\OrderInterface as CoreOrderInterface;
use Sylius\Component\Core\OrderCheckoutStates;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Webmozart\Assert\Assert;

final readonly class AfterCheckoutOrderPaymentProcessor implements OrderProcessorInterface
{
    public function __construct(private OrderProcessorInterface $baseAfterCheckoutOrderPaymentProcessor)
    {
    }

    /**
     * @param CoreOrderInterface $order
     */
    public function process(OrderInterface $order): void
    {
        Assert::isInstanceOf($order, CoreOrderInterface::class);

        if ($order->getCheckoutState() !== OrderCheckoutStates::STATE_COMPLETED) {
            return;
        }

        $this->baseAfterCheckoutOrderPaymentProcessor->process($order);
    }
}
