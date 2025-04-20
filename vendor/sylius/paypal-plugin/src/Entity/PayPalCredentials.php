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

namespace Sylius\PayPalPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\PaymentMethodInterface;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_paypal_plugin_pay_pal_credentials')]
class PayPalCredentials implements PayPalCredentialsInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\ManyToOne(targetEntity: PaymentMethodInterface::class)]
    #[ORM\JoinColumn(name: 'payment_method_id', referencedColumnName: 'id')]
    private PaymentMethodInterface $paymentMethod;

    #[ORM\Column(name: 'access_token', type: 'string')]
    private string $accessToken;

    #[ORM\Column(name: 'creation_time', type: 'datetime')]
    private \DateTime $creationTime;

    #[ORM\Column(name: 'expiration_time', type: 'datetime')]
    private \DateTime $expirationTime;

    public function __construct(
        string $id,
        PaymentMethodInterface $paymentMethod,
        string $accessToken,
        \DateTime $creationTime,
        int $expiresIn,
    ) {
        $this->id = $id;
        $this->paymentMethod = $paymentMethod;
        $this->accessToken = $accessToken;
        $this->creationTime = $creationTime;
        $this->expirationTime = (clone $creationTime)->modify('+' . $expiresIn . ' seconds');
    }

    public function id(): string
    {
        return $this->id;
    }

    public function paymentMethod(): PaymentMethodInterface
    {
        return $this->paymentMethod;
    }

    public function accessToken(): string
    {
        return $this->accessToken;
    }

    public function creationTime(): \DateTime
    {
        return $this->creationTime;
    }

    public function expirationTime(): \DateTime
    {
        return $this->expirationTime;
    }

    public function isExpired(): bool
    {
        return new \DateTime() > $this->expirationTime;
    }
}
