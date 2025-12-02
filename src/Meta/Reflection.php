<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Meta;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionEnumUnitCase;
use ReflectionObject;
use UnitEnum;

use function array_filter;
use function array_map;
use function array_merge;
use function array_values;

/**
 * @author Brian Faust <brian@cline.sh>
 */
final class Reflection
{
    /**
     * Get the meta properties enabled on an Enum.
     *
     * @return array<int, class-string<MetaProperty>|string>
     */
    public static function metaProperties(UnitEnum $enum): array
    {
        $reflection = new ReflectionObject($enum);
        $metaProperties = self::parseMetaProperties($reflection);

        // Traits except the `Metadata` trait
        $traits = array_values(array_filter($reflection->getTraits(), fn (ReflectionClass $class): bool => $class->getName() !== 'Cline\Enums\Metadata'));

        $traitsMeta = array_map(
            self::parseMetaProperties(...),
            $traits,
        );

        return array_merge($metaProperties, ...$traitsMeta);
    }

    /**
     * Get the value of a meta property on the provided enum.
     *
     * @param class-string<MetaProperty> $metaProperty
     */
    public static function metaValue(string $metaProperty, UnitEnum $enum): mixed
    {
        // Find the case used by $enum
        $reflection = new ReflectionEnumUnitCase($enum::class, $enum->name);
        $attributes = $reflection->getAttributes();

        // Instantiate each ReflectionAttribute
        /** @var array<MetaProperty> $properties */
        $properties = array_map(fn (ReflectionAttribute $attr): object => $attr->newInstance(), $attributes);

        // Find the property that matches the $metaProperty class
        $properties = array_filter($properties, fn (MetaProperty $property): bool => $property::class === $metaProperty);

        // Reset array index
        $properties = array_values($properties);

        if ($properties !== []) {
            return $properties[0]->value;
        }

        return $metaProperty::defaultValue();
    }

    /**
     * @param  ReflectionClass<object>                       $reflection
     * @return array<int, class-string<MetaProperty>|string>
     */
    private static function parseMetaProperties(ReflectionClass $reflection): array
    {
        // Only the `Meta` attribute
        $attributes = $reflection->getAttributes(Meta::class);

        if ($attributes !== []) {
            /** @var Meta $meta */
            $meta = $attributes[0]->newInstance();

            return $meta->metaProperties;
        }

        return [];
    }
}
