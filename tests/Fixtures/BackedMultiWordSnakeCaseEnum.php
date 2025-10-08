<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Fixtures;

use Cline\Enums\Concerns\Options;

enum BackedMultiWordSnakeCaseEnum: int
{
    use Options;

    case FOO_BAR = 0;
    case BAR_BAZ = 1;
}
