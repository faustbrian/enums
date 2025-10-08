<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Fixtures;

use Cline\Enums\Concerns\Comparable;
use Cline\Enums\Concerns\From;
use Cline\Enums\Concerns\InvokableCases;
use Cline\Enums\Concerns\Metadata;
use Cline\Enums\Concerns\Names;
use Cline\Enums\Concerns\Options;
use Cline\Enums\Concerns\Values;
use Cline\Enums\Meta\Meta;

#[Meta([Color::class, Desc::class, Instructions::class])] // array
enum Role
{
    use InvokableCases;
    use Options;
    use Names;
    use Values;
    use From;
    use Metadata;
    use Comparable;

    #[Color('indigo')]
    #[Desc('Administrator')]
    #[Instructions('Administrators can manage the entire account')]
    case ADMIN;

    #[Color('gray')]
    #[Desc('Read-only guest')]
    #[Instructions('Guest users can only view the existing records')]
    case GUEST;
}
