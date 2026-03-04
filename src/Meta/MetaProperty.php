<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Meta;

use ReflectionClass;

use function end;
use function explode;
use function is_string;
use function lcfirst;

/**
 * @author Brian Faust <brian@cline.sh>
 */
abstract class MetaProperty
{
    final public function __construct(
        public mixed $value,
    ) {
        $this->value = $this->transform($value);
    }

    public static function defaultValue(): mixed
    {
        return null;
    }

    public static function make(mixed $value): static
    {
        return new static($value);
    }

    /**
     * Get the name of the accessor method
     */
    public static function method(): string
    {
        // Check if the child class has defined a static $method property
        $reflection = new ReflectionClass(static::class);

        if ($reflection->hasProperty('method')) {
            $property = $reflection->getProperty('method');

            if ($property->isStatic()) {
                $value = $property->getValue();

                return is_string($value) ? $value : '';
            }
        }

        $parts = explode('\\', static::class);
        $lastPart = end($parts);

        return lcfirst($lastPart);
    }

    protected function transform(mixed $value): mixed
    {
        // Feel free to override this to transform the value during instantiation

        return $value;
    }
}
