<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Exceptions;

use ValueError;

use function sprintf;

/**
 * Exception thrown when an enum case cannot be found by meta property value.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class InvalidMetaPropertyValueException extends ValueError implements EnumsException
{
    public static function forProperty(string $enumName, string $propertyName, string $value): self
    {
        return new self(sprintf(
            'Enum %s does not have a case with a meta property "%s" of value "%s"',
            $enumName,
            $propertyName,
            $value,
        ));
    }
}
