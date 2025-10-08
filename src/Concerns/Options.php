<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Concerns;

use BackedEnum;
use Closure;

use function array_column;
use function array_combine;
use function array_filter;
use function array_key_exists;
use function array_keys;
use function array_map;
use function array_values;
use function explode;
use function implode;
use function mb_strtolower;
use function mb_strtoupper;
use function preg_split;
use function str_contains;
use function ucfirst;

trait Options
{
    /**
     * Get an associative array of [case name => case value] or an indexed array [case name, case name] in the case of pure enums.
     *
     * @return array<int|string, int|string>
     */
    public static function options(): array
    {
        $cases = static::cases();

        /** @var array<int|string, int|string> */
        return array_key_exists(0, $cases) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value', 'name')
            : array_column($cases, 'name');
    }

    /**
     * Generate a string format of the enum options using the provided callback and glue.
     *
     * @param null|(Closure(int|string, int|string): string) $callback
     */
    public static function stringOptions(?Closure $callback = null, string $glue = '\n'): string
    {
        $firstCase = static::cases()[0] ?? null;

        if ($firstCase === null) {
            return '';
        }

        // [name, name]
        $options = static::options();

        if (!$firstCase instanceof BackedEnum) {
            // [name => name, name => name]
            $options = array_combine($options, $options);
        }

        // Default callback
        $callback ??= function (int|string $name, int|string $value): string {
            if (str_contains((string) $name, '_')) {
                // Snake case
                $words = explode('_', (string) $name);
            } elseif (mb_strtoupper((string) $name) === (string) $name) {
                // If the entire name is uppercase without underscores, it's a single word
                $words = [(string) $name];
            } else {
                // Pascal case or camel case
                $words = array_filter(preg_split('/(?=[A-Z])/', (string) $name) ?: []);
            }

            return "<option value=\"{$value}\">".ucfirst(mb_strtolower(implode(' ', $words))).'</option>';
        };

        $options = array_map($callback, array_keys($options), array_values($options));

        return implode($glue, $options);
    }
}
