<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Fixtures;

use Cline\Enums\Concerns\Metadata;
use Cline\Enums\Meta\Meta;

#[Meta([Config::class])]
/**
 * @author Brian Faust <brian@cline.sh>
 */
enum Feature
{
    use Metadata;

    #[Config(['enabled' => true, 'limit' => 100])]
    case FEATURE_A;

    #[Config(['enabled' => false, 'limit' => 50])]
    case FEATURE_B;
}
