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
 * Exception thrown when an invalid name is used to resolve an enum case.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class InvalidEnumNameException extends ValueError implements EnumsException
{
    public static function forName(string $name, string $enumName): self
    {
        return new self(sprintf('"%s" is not a valid name for enum %s', $name, $enumName));
    }
}
