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

namespace Sylius\Bundle\GridBundle\Doctrine\PHPCRODM;

use Sylius\Component\Grid\Data\MemberOfAwareExpressionBuilderInterface;

@trigger_error(sprintf('The "%s" class is deprecated since Sylius 1.3. Doctrine MongoDB and PHPCR support will no longer be supported in Sylius 2.0.', ExpressionBuilderInterface::class), \E_USER_DEPRECATED);

interface ExpressionBuilderInterface extends MemberOfAwareExpressionBuilderInterface
{
    public function getOrderBys(): array;
}
