<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Exceptions;

use Error;

use function sprintf;

/**
 * @author Brian Faust <brian@cline.sh>
 */
final class UndefinedCaseError extends Error implements EnumsException
{
    public static function forCase(string $enum, string $case): self
    {
        // Matches the error message of invalid Foo::BAR access
        return new self(sprintf('Undefined constant %s::%s', $enum, $case));
    }
}
