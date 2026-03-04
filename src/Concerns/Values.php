<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Concerns;

use BackedEnum;

use function array_column;
use function array_key_exists;

/**
 * @author Brian Faust <brian@cline.sh>
 */
trait Values
{
    /**
     * Get an array of case values.
     *
     * @return array<int, int|string>
     */
    public static function values(): array
    {
        $cases = static::cases();

        $result = array_key_exists(0, $cases) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value')
            : array_column($cases, 'name');

        /** @var array<int, int|string> $result */
        return $result;
    }
}
