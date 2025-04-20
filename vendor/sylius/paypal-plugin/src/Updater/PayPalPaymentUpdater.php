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

namespace Sylius\PayPalPlugin\Updater;

use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Core\Model\PaymentInterface;

final readonly class PayPalPaymentUpdater implements PaymentUpdaterInterface
{
    public function __construct(private ObjectManager $paymentManager)
    {
    }

    public function updateAmount(PaymentInterface $payment, int $newAmount): void
    {
        $payment->setAmount($newAmount);

        $this->paymentManager->flush();
    }
}
