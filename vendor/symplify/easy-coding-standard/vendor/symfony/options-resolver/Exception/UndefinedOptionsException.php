<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix202503\Symfony\Component\OptionsResolver\Exception;

/**
 * Exception thrown when an undefined option is passed.
 *
 * You should remove the options in question from your code or define them
 * beforehand.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class UndefinedOptionsException extends InvalidArgumentException
{
}
