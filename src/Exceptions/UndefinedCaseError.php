<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Exceptions;

use Error;

final class UndefinedCaseError extends Error
{
    public function __construct(string $enum, string $case)
    {
        // Matches the error message of invalid Foo::BAR access
        parent::__construct("Undefined constant {$enum}::{$case}");
    }
}
