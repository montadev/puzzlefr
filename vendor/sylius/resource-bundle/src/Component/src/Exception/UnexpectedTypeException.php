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

class UnexpectedTypeException extends InvalidArgumentException
{
    /**
     * @param mixed $value
     */
    public function __construct($value, string $expectedType)
    {
        parent::__construct(sprintf(
            'Expected argument of type "%s", "%s" given.',
            $expectedType,
            get_debug_type($value),
        ));
    }
}

class_alias(UnexpectedTypeException::class, \Sylius\Component\Resource\Exception\UnexpectedTypeException::class);
