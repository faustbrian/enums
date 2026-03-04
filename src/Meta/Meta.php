<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums\Meta;

use Attribute;

use function array_key_exists;
use function is_array;

/**
 * @author Brian Faust <brian@cline.sh>
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Meta
{
    /** @var array<int, class-string<MetaProperty>|string> */
    public array $metaProperties;

    /**
     * @param array<int, class-string<MetaProperty>|string>|class-string<MetaProperty>|string ...$metaProperties
     */
    public function __construct(array|string ...$metaProperties)
    {
        // When an array is passed, it'll be wrapped in an outer array due to the ...variadic parameter
        if (array_key_exists(0, $metaProperties) && is_array($metaProperties[0])) {
            // Extract the inner array
            /** @var array<int, class-string<MetaProperty>|string> $innerArray */
            $innerArray = $metaProperties[0];
            $this->metaProperties = $innerArray;
        } else {
            /** @var array<int, class-string<MetaProperty>|string> $metaProperties */
            $this->metaProperties = $metaProperties;
        }
    }
}
