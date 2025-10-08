<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Concerns;

use BackedEnum;
use Cline\Enums\Exceptions\UndefinedCaseError;
use UnitEnum;

trait InvokableCases
{
    /**
     * Return the enum's value when it's $invoked().
     */
    public function __invoke(): int|string
    {
        /** @phpstan-ignore-next-line */
        return $this instanceof BackedEnum ? $this->value : $this->name;
    }

    /**
     * Return the enum's value or name when it's called ::STATICALLY().
     *
     * @param array<int, mixed> $args
     */
    public static function __callStatic(string $name, array $args): int|string
    {
        $cases = static::cases();

        foreach ($cases as $case) {
            /** @var UnitEnum $case */
            if ($case->name === $name) {
                return $case instanceof BackedEnum ? $case->value : $case->name;
            }
        }

        throw new UndefinedCaseError(static::class, $name);
    }
}
