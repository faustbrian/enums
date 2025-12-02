<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Concerns;

/**
 * @author Brian Faust <brian@cline.sh>
 */
trait Comparable
{
    public function is(mixed $enum): bool
    {
        return $this === $enum;
    }

    public function isNot(mixed $enum): bool
    {
        return !$this->is($enum);
    }

    /**
     * @param iterable<static> $enums
     */
    public function in(iterable $enums): bool
    {
        foreach ($enums as $item) {
            if ($this->is($item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param iterable<static> $enums
     */
    public function notIn(iterable $enums): bool
    {
        return !$this->in($enums);
    }
}
