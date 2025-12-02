<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Concerns;

use Cline\Enums\Exceptions\InvalidMetaPropertyValueException;
use Cline\Enums\Meta\MetaProperty;
use Cline\Enums\Meta\Reflection;
use ReflectionClass;
use UnitEnum;

use function is_float;
use function is_int;
use function is_string;
use function json_encode;

/**
 * @author Brian Faust <brian@cline.sh>
 */
trait Metadata
{
    /**
     * @param array<int, mixed> $arguments
     */
    public function __call(string $property, array $arguments): mixed
    {
        /** @phpstan-ignore-next-line */
        $metaProperties = Reflection::metaProperties($this);

        foreach ($metaProperties as $metaProperty) {
            /** @var class-string<MetaProperty> $metaPropertyClass */
            $metaPropertyClass = $metaProperty;

            if ($metaPropertyClass::method() === $property) {
                /** @phpstan-ignore-next-line */
                return Reflection::metaValue($metaProperty, $this);
            }
        }

        return null;
    }

    /**
     * Try to get the first case with this meta property value.
     */
    public static function tryFromMeta(MetaProperty $metaProperty): ?static
    {
        foreach (static::cases() as $case) {
            /** @var UnitEnum $case */
            if (Reflection::metaValue($metaProperty::class, $case) === $metaProperty->value) {
                /** @var static $case */
                return $case;
            }
        }

        return null;
    }

    /**
     * Get the first case with this meta property value.
     *
     * @throws InvalidMetaPropertyValueException
     */
    public static function fromMeta(MetaProperty $metaProperty): static
    {
        $enumName = new ReflectionClass(static::class)->getShortName();
        $propertyName = new ReflectionClass($metaProperty::class)->getShortName();
        $value = is_string($metaProperty->value) || is_int($metaProperty->value) || is_float($metaProperty->value)
            ? (string) $metaProperty->value
            : (json_encode($metaProperty->value) ?: '');

        return static::tryFromMeta($metaProperty) ?? throw InvalidMetaPropertyValueException::forProperty(
            $enumName,
            $propertyName,
            $value,
        );
    }
}
