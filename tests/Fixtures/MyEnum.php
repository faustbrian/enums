<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Fixtures;

use Cline\Enums\Concerns\Metadata;

/**
 * @author Brian Faust <brian@cline.sh>
 */
enum MyEnum
{
    use Metadata;
    use HasDescription;

    #[Description('Foo!')]
    case FOO;

    #[Description('Bar!')]
    case BAR;

    case BAZ;
}
