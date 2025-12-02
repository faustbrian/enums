<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Concerns;

use Cline\Enums\Exceptions\InvalidEnumNameException;
use ReflectionClass;
use UnitEnum;

use function array_filter;
use function array_values;

/**
 * @author Brian Faust <brian@cline.sh>
 */
trait From
{
    /**
     * Gets the Enum by name, if it exists, for "Pure" enums.
     *
     * This will not override the `from()` method on BackedEnums
     *
     * @throws InvalidEnumNameException
     */
    public static function from(int|string $case): static
    {
        return static::fromName((string) $case);
    }

    /**
     * Gets the Enum by name, if it exists, for "Pure" enums.
     *
     * This will not override the `tryFrom()` method on BackedEnums
     */
    public static function tryFrom(int|string $case): ?static
    {
        return static::tryFromName((string) $case);
    }

    /**
     * Gets the Enum by name.
     *
     * @throws InvalidEnumNameException
     */
    public static function fromName(string $case): static
    {
        $className = new ReflectionClass(static::class)->getShortName();

        return static::tryFromName($case) ?? throw InvalidEnumNameException::forName($case, $className);
    }

    /**
     * Gets the Enum by name, if it exists.
     */
    public static function tryFromName(string $case): ?static
    {
        /** @var array<int, static> $cases */
        $cases = array_filter(
            static::cases(),
            fn (mixed $c): bool => $c instanceof UnitEnum && $c->name === $case,
        );

        return array_values($cases)[0] ?? null;
    }
}
