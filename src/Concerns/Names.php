<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Concerns;

use function array_column;

/**
 * @author Brian Faust <brian@cline.sh>
 */
trait Names
{
    /**
     * Get an array of case names.
     *
     * @return array<int, string>
     */
    public static function names(): array
    {
        /** @var array<int, string> */
        return array_column(static::cases(), 'name');
    }
}
