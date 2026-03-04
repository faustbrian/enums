<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Enums;

use Cline\Enums\Concerns\Comparable;
use Cline\Enums\Concerns\From;
use Cline\Enums\Concerns\InvokableCases;
use Cline\Enums\Concerns\Metadata;
use Cline\Enums\Concerns\Names;
use Cline\Enums\Concerns\Options;
use Cline\Enums\Concerns\Values;

/**
 * Abstract base enum class that incorporates all available enum traits.
 *
 * Extend this class for a fully-featured enum with all capabilities:
 * - Case comparison and matching
 * - Dynamic instantiation from various formats
 * - Invokable cases
 * - Metadata and attribute support
 * - Name extraction and formatting
 * - Options generation for forms/selects
 * - Value extraction and manipulation
 *
 * @property string $name
 *
 * @method static array<int, static> cases()
 *
 * @author Brian Faust <brian@cline.sh>
 */
abstract class Enum
{
    use Comparable;
    use From;
    use InvokableCases;
    use Metadata;
    use Names;
    use Options;
    use Values;
}
