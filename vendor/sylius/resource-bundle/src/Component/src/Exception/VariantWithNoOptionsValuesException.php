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

namespace Sylius\Resource\Exception;

final class VariantWithNoOptionsValuesException extends Exception
{
    public function __construct()
    {
        parent::__construct('sylius.product_variant.cannot_generate_variants');
    }
}

class_alias(VariantWithNoOptionsValuesException::class, \Sylius\Component\Resource\Exception\VariantWithNoOptionsValuesException::class);
