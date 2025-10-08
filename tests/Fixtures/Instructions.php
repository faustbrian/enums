<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Fixtures;

use Attribute;
use Cline\Enums\Meta\MetaProperty;

#[Attribute()]
final class Instructions extends MetaProperty
{
    public static string $method = 'help';

    protected function transform(mixed $value): mixed
    {
        return 'Help: '.$value;
    }
}
