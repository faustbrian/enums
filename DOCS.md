## Table of Contents

1. [Getting Started](#doc-docs-readme) (`docs/README.md`)
2. [Quick Reference](#doc-docs-quick-reference) (`docs/quick-reference.md`)
3. [InvokableCases](#doc-docs-invokable-cases) (`docs/invokable-cases.md`)
4. [Collections](#doc-docs-collections) (`docs/collections.md`)
5. [Instantiation](#doc-docs-instantiation) (`docs/instantiation.md`)
6. [Metadata](#doc-docs-metadata) (`docs/metadata.md`)
7. [Comparable](#doc-docs-comparable) (`docs/comparable.md`)
<a id="doc-docs-readme"></a>

A collection of enum helpers for PHP that enhance native PHP enums with powerful features and utilities.

## Requirements

> **Requires [PHP 8.4+](https://php.net/releases/)**

## Installation

```bash
composer require cline/enums
```

## Quick Example

```php
use Cline\Enums\Concerns\InvokableCases;
use Cline\Enums\Concerns\Names;
use Cline\Enums\Concerns\Values;

enum TaskStatus: int
{
    use InvokableCases, Names, Values;

    case Incomplete = 0;
    case Completed = 1;
    case Canceled = 2;
}

// Get the value by invoking
TaskStatus::Completed(); // 1

// Get all names
TaskStatus::names(); // ['Incomplete', 'Completed', 'Canceled']

// Get all values
TaskStatus::values(); // [0, 1, 2]
```

## Available Traits

- **[InvokableCases](#doc-docs-invokable-cases)** - Get enum values by invoking cases
- **[Names](#)** - Get list of case names
- **[Values](#)** - Get list of case values
- **[Options](#)** - Get associative arrays for forms
- **[From](#doc-docs-instantiation)** - Enhanced instantiation methods
- **[Metadata](#doc-docs-metadata)** - Add custom properties to cases
- **[Comparable](#doc-docs-comparable)** - Compare enum instances

<a id="doc-docs-quick-reference"></a>

This page provides a quick overview of the main features available in the enums package.

## Core Features

- **InvokableCases**: Use `MyEnum::FOO()` instead of `MyEnum::FOO->value`
- **Names & Values**: Get all case names or values as arrays
- **Options**: Generate form-ready arrays and HTML options
- **Metadata**: Attach custom properties to cases with attributes
- **Comparable**: Use `->is()`, `->in()` for readable comparisons
- **From**: Create instances from names with `fromName()`

## Common Patterns

```php
use Cline\Enums\Concerns\{InvokableCases, Names, Values, Comparable};

enum Status: int
{
    use InvokableCases, Names, Values, Comparable;

    case Draft = 0;
    case Published = 1;
    case Archived = 2;
}

// Get value without ->value
Status::Published(); // 1

// Collections
Status::names(); // ['Draft', 'Published', 'Archived']
Status::values(); // [0, 1, 2]

// Comparisons
$status->is(Status::Published); // true
$status->in([Status::Draft, Status::Published]); // true
```

## See Also

- **[Getting Started](#doc-docs-readme)** - Installation and basic usage
- **[InvokableCases](#doc-docs-invokable-cases)** - Get enum values without ->value
- **[Collections](#doc-docs-collections)** - Names, values, and options methods
- **[Instantiation](#doc-docs-instantiation)** - Enhanced from() and fromName() methods
- **[Metadata](#doc-docs-metadata)** - Add custom properties to enum cases
- **[Comparable](#doc-docs-comparable)** - Compare enum instances with is(), in()

<a id="doc-docs-invokable-cases"></a>

Get the value of a backed enum, or the name of a pure enum, by invoking it statically (`MyEnum::FOO()`) or as an instance (`$enum()`).

## Benefits

Eliminates the need to append `->value` when working with backed enums:

```php
// Without InvokableCases
'statuses' => [
    TaskStatus::Incomplete->value => ['some configuration'],
    TaskStatus::Completed->value => ['some configuration'],
];

// With InvokableCases
'statuses' => [
    TaskStatus::Incomplete() => ['some configuration'],
    TaskStatus::Completed() => ['some configuration'],
];
```

## Setup

```php
use Cline\Enums\Concerns\InvokableCases;

enum TaskStatus: int
{
    use InvokableCases;

    case Incomplete = 0;
    case Completed = 1;
    case Canceled = 2;
}

enum Role
{
    use InvokableCases;

    case Administrator;
    case Subscriber;
    case Guest;
}
```

## Static Invocation

Get the primitive value by invoking cases statically:

```php
// Backed enum returns the value
TaskStatus::Incomplete(); // 0
TaskStatus::Completed(); // 1
TaskStatus::Canceled(); // 2

// Pure enum returns the name
Role::Administrator(); // 'Administrator'
Role::Subscriber(); // 'Subscriber'
Role::Guest(); // 'Guest'
```

## Instance Invocation

Invoke enum instances to get their primitive value:

```php
public function updateStatus(TaskStatus $status, Role $role)
{
    // Invoke the instances to get their values
    $this->record->setStatus($status(), $role());
}
```

## Use Cases

### Array Keys

Configure mappings and associative arrays:

```php
$config = [
    TaskStatus::Incomplete() => ['color' => 'yellow', 'icon' => 'clock'],
    TaskStatus::Completed() => ['color' => 'green', 'icon' => 'check'],
    TaskStatus::Canceled() => ['color' => 'red', 'icon' => 'x'],
];
```

### Method Parameters

Pass primitive values to methods expecting them:

```php
public function updateStatus(int $status): void;

// Clean invocation without ->value
$task->updateStatus(TaskStatus::Completed());
```

### Database Queries

Use in database queries without appending `->value`:

```php
$tasks = Task::where('status', TaskStatus::Incomplete())->get();
```

## IDE Support

InvokableCases provides full IDE autocompletion. Add parentheses to convert suggestions to primitive values:

```php
MyEnum::FOO;   // MyEnum instance (IDE autocompletes)
MyEnum::FOO(); // Primitive value (add parentheses)
```

<a id="doc-docs-collections"></a>

Traits for getting collections of enum names, values, and options.

## Names

Returns a list of case names in the enum.

### Setup

```php
use Cline\Enums\Concerns\Names;

enum TaskStatus: int
{
    use Names;

    case Incomplete = 0;
    case Completed = 1;
    case Canceled = 2;
}

enum Role
{
    use Names;

    case Administrator;
    case Subscriber;
    case Guest;
}
```

### Usage

```php
TaskStatus::names(); // ['Incomplete', 'Completed', 'Canceled']
Role::names(); // ['Administrator', 'Subscriber', 'Guest']
```

## Values

Returns a list of case values for backed enums, or case names for pure enums.

### Setup

```php
use Cline\Enums\Concerns\Values;

enum TaskStatus: int
{
    use Values;

    case Incomplete = 0;
    case Completed = 1;
    case Canceled = 2;
}

enum Role
{
    use Values;

    case Administrator;
    case Subscriber;
    case Guest;
}
```

### Usage

```php
// Backed enum returns values
TaskStatus::values(); // [0, 1, 2]

// Pure enum returns names (same as ::names())
Role::values(); // ['Administrator', 'Subscriber', 'Guest']
```

## Options

Returns an associative array of case names and values for form selects and validation.

### Setup

```php
use Cline\Enums\Concerns\Options;

enum TaskStatus: int
{
    use Options;

    case Incomplete = 0;
    case Completed = 1;
    case Canceled = 2;
}

enum Role
{
    use Options;

    case Administrator;
    case Subscriber;
    case Guest;
}
```

### Basic Usage

```php
// Backed enum returns name => value pairs
TaskStatus::options(); // ['Incomplete' => 0, 'Completed' => 1, 'Canceled' => 2]

// Pure enum returns list of names
Role::options(); // ['Administrator', 'Subscriber', 'Guest']
```

### String Options

Generate string representations of your enum options with `stringOptions()`:

```php
// Custom format with callback and glue
TaskStatus::stringOptions(fn ($name, $value) => "$name => $value", ', ');
// Returns: "Incomplete => 0, Completed => 1, Canceled => 2"
```

For pure enums, both `$name` and `$value` in the callback are the same.

### HTML Options

By default, `stringOptions()` generates HTML `<option>` tags:

```php
// Backed enum generates option tags with values
TaskStatus::stringOptions();
// <option value="0">Incomplete</option>
// <option value="1">Completed</option>
// <option value="2">Canceled</option>

// Pure enum uses name as both value and label
Role::stringOptions();
// <option value="Administrator">Administrator</option>
// <option value="Subscriber">Subscriber</option>
// <option value="Guest">Guest</option>
```

The method automatically converts case names to human-readable format (e.g., `INCOMPLETE` becomes `Incomplete`).

## Use Cases

### Form Selects

```php
<select name="status">
    <?php foreach (TaskStatus::options() as $name => $value): ?>
        <option value="<?= $value ?>"><?= $name ?></option>
    <?php endforeach; ?>
</select>
```

### Validation Rules

```php
$rules = [
    'status' => ['required', Rule::in(TaskStatus::values())],
];
```

### API Documentation

```php
/**
 * @param int $status One of: {TaskStatus::stringOptions(fn($n, $v) => $v, ', ')}
 */
public function updateStatus(int $status): void
{
    // ...
}
```

<a id="doc-docs-instantiation"></a>

Enhanced methods for creating enum instances from values and names.

## Overview

The `From` trait adds:
- `from()` and `tryFrom()` methods to pure enums
- `fromName()` and `tryFromName()` methods to all enums

> **Note:** BackedEnum instances already have `from()` and `tryFrom()` methods which won't be overridden.

## Setup

```php
use Cline\Enums\Concerns\From;

enum TaskStatus: int
{
    use From;

    case Incomplete = 0;
    case Completed = 1;
    case Canceled = 2;
}

enum Role
{
    use From;

    case Administrator;
    case Subscriber;
    case Guest;
}
```

## Pure Enums

For pure enums, `from()` and `tryFrom()` work with case names:

### from()

Throws `ValueError` if the case doesn't exist:

```php
Role::from('Administrator'); // Role::Administrator
Role::from('Nobody'); // Error: ValueError
```

### tryFrom()

Returns `null` if the case doesn't exist:

```php
Role::tryFrom('Guest'); // Role::Guest
Role::tryFrom('Never'); // null
```

## All Enums

Both backed and pure enums can use name-based instantiation:

### fromName()

Throws `ValueError` if the case doesn't exist:

```php
// Backed enum
TaskStatus::fromName('Incomplete'); // TaskStatus::Incomplete
TaskStatus::fromName('Missing'); // Error: ValueError

// Pure enum
Role::fromName('Subscriber'); // Role::Subscriber
Role::fromName('Hacker'); // Error: ValueError
```

### tryFromName()

Returns `null` if the case doesn't exist:

```php
// Backed enum
TaskStatus::tryFromName('Completed'); // TaskStatus::Completed
TaskStatus::tryFromName('Nothing'); // null

// Pure enum
Role::tryFromName('Guest'); // Role::Guest
Role::tryFromName('Tester'); // null
```

## Use Cases

### Safe Instantiation

When dealing with user input or external data:

```php
$status = TaskStatus::tryFromName($request->get('status'));

if ($status === null) {
    return response()->json(['error' => 'Invalid status'], 400);
}
```

### Flexible APIs

Accept both values and names:

```php
public function setStatus(int|string $status): void
{
    $this->status = is_int($status)
        ? TaskStatus::from($status)
        : TaskStatus::fromName($status);
}
```

### Migration Support

When transitioning from string constants to enums:

```php
// Old code used strings
const STATUS_INCOMPLETE = 'Incomplete';

// New code can still instantiate from those strings
$status = TaskStatus::fromName(self::STATUS_INCOMPLETE);
```

### Dynamic Case Resolution

```php
$caseNames = ['Administrator', 'Subscriber', 'Guest'];

$roles = array_map(
    fn($name) => Role::fromName($name),
    $caseNames
);
```

<a id="doc-docs-metadata"></a>

Add custom properties and behaviors to enum cases using attributes.

## Overview

The Metadata trait allows you to:
- Attach custom properties to enum cases
- Access properties via dynamic methods
- Find cases by metadata values
- Transform property values automatically

## Basic Setup

```php
use Cline\Enums\Concerns\Metadata;
use Cline\Enums\Meta\Meta;
use Cline\Enums\Meta\MetaProperty;

// Define your meta properties
#[Attribute]
class Description extends MetaProperty {}

#[Attribute]
class Color extends MetaProperty {}

// Apply to your enum
#[Meta(Description::class, Color::class)]
enum TaskStatus: int
{
    use Metadata;

    #[Description('Incomplete Task')] #[Color('red')]
    case Incomplete = 0;

    #[Description('Completed Task')] #[Color('green')]
    case Completed = 1;

    #[Description('Canceled Task')] #[Color('gray')]
    case Canceled = 2;
}
```

## Accessing Metadata

```php
TaskStatus::Incomplete->description(); // 'Incomplete Task'
TaskStatus::Completed->color(); // 'green'
```

## Creating Meta Properties

Each meta property is a class extending `MetaProperty`:

```php
#[Attribute]
class Color extends MetaProperty {}

#[Attribute]
class Description extends MetaProperty {}

#[Attribute]
class Icon extends MetaProperty {}
```

## Advanced Features

### Custom Method Names

Override the default method name:

```php
#[Attribute]
class Description extends MetaProperty
{
    public static function method(): string
    {
        return 'note'; // Use ->note() instead of ->description()
    }
}
```

### Value Transformation

Transform values before they're returned:

```php
#[Attribute]
class Color extends MetaProperty
{
    protected function transform(mixed $value): mixed
    {
        return "text-{$value}-500"; // 'green' becomes 'text-green-500'
    }
}
```

### Default Values

Provide defaults for cases without the attribute:

```php
#[Attribute]
class Priority extends MetaProperty
{
    public function defaultValue(): mixed
    {
        return 'normal'; // Cases without Priority attribute return 'normal'
    }
}
```

## Finding Cases by Metadata

### fromMeta()

Find a case by its metadata value (throws `ValueError` if not found):

```php
TaskStatus::fromMeta(Color::make('green')); // TaskStatus::COMPLETED
TaskStatus::fromMeta(Color::make('blue')); // Error: ValueError
```

### tryFromMeta()

Find a case by its metadata value (returns `null` if not found):

```php
TaskStatus::tryFromMeta(Color::make('green')); // TaskStatus::COMPLETED
TaskStatus::tryFromMeta(Color::make('blue')); // null
```

## Real-World Examples

### UI Configuration

```php
#[Attribute]
class Color extends MetaProperty {}

#[Attribute]
class Icon extends MetaProperty {}

#[Attribute]
class Label extends MetaProperty {}

#[Meta(Color::class, Icon::class, Label::class)]
enum OrderStatus: string
{
    use Metadata;

    #[Color('yellow')] #[Icon('clock')] #[Label('Pending')]
    case Pending = 'pending';

    #[Color('blue')] #[Icon('truck')] #[Label('Shipped')]
    case Shipped = 'shipped';

    #[Color('green')] #[Icon('check')] #[Label('Delivered')]
    case Delivered = 'delivered';
}

// In your view
<span class="text-<?= $order->status->color() ?>-500">
    <i class="icon-<?= $order->status->icon() ?>"></i>
    <?= $order->status->label() ?>
</span>
```

### Permissions & Roles

```php
#[Attribute]
class Permissions extends MetaProperty
{
    protected function transform(mixed $value): array
    {
        return is_string($value) ? explode(',', $value) : $value;
    }
}

#[Meta(Permissions::class)]
enum Role: string
{
    use Metadata;

    #[Permissions('read')]
    case GUEST = 'guest';

    #[Permissions('read,write')]
    case USER = 'user';

    #[Permissions('read,write,delete,admin')]
    case ADMIN = 'admin';
}

if (in_array('write', $user->role->permissions())) {
    // User can write
}
```

### State Machine Transitions

```php
#[Attribute]
class AllowedTransitions extends MetaProperty {}

#[Meta(AllowedTransitions::class)]
enum OrderStatus: string
{
    use Metadata;

    #[AllowedTransitions(['shipped', 'canceled'])]
    case Pending = 'pending';

    #[AllowedTransitions(['delivered', 'returned'])]
    case Shipped = 'shipped';

    #[AllowedTransitions(['returned'])]
    case Delivered = 'delivered';
}

$canTransitionTo = in_array(
    $newStatus->value,
    $currentStatus->allowedTransitions()
);
```

## IDE Support

Add `@method` annotations for better IDE support:

```php
/**
 * @method string description()
 * @method string color()
 * @method string icon()
 */
#[Meta(Description::class, Color::class, Icon::class)]
enum TaskStatus: int
{
    use Metadata;
    // ...
}
```

Or create a trait for reusable metadata:

```php
/**
 * @method string color()
 * @method string icon()
 */
trait HasUIMetadata
{
    use Metadata;
}

#[Meta(Color::class, Icon::class)]
enum TaskStatus: int
{
    use HasUIMetadata;
    // ...
}
```

<a id="doc-docs-comparable"></a>

Compare enum instances using convenient methods.

## Overview

The Comparable trait provides methods for comparing enum instances:
- `is()` - Check if equal to another instance
- `isNot()` - Check if not equal to another instance
- `in()` - Check if in a list of instances
- `notIn()` - Check if not in a list of instances

## Setup

```php
use Cline\Enums\Concerns\Comparable;

enum TaskStatus: int
{
    use Comparable;

    case Incomplete = 0;
    case Completed = 1;
    case Canceled = 2;
}

enum Role
{
    use Comparable;

    case Administrator;
    case Subscriber;
    case Guest;
}
```

## Methods

### is()

Check if an enum instance equals another:

```php
$status = TaskStatus::Incomplete;

$status->is(TaskStatus::Incomplete); // true
$status->is(TaskStatus::Completed); // false

$role = Role::Administrator;
$role->is(Role::Administrator); // true
$role->is(Role::Subscriber); // false
```

### isNot()

Check if an enum instance does not equal another:

```php
$status = TaskStatus::Incomplete;

$status->isNot(TaskStatus::Incomplete); // false
$status->isNot(TaskStatus::Completed); // true

$role = Role::Administrator;
$role->isNot(Role::Administrator); // false
$role->isNot(Role::Subscriber); // true
```

### in()

Check if an enum instance is in a list:

```php
$status = TaskStatus::Incomplete;

$status->in([TaskStatus::Incomplete, TaskStatus::Completed]); // true
$status->in([TaskStatus::Completed, TaskStatus::Canceled]); // false

$role = Role::Administrator;
$role->in([Role::Administrator, Role::Guest]); // true
$role->in([Role::Subscriber, Role::Guest]); // false
```

### notIn()

Check if an enum instance is not in a list:

```php
$status = TaskStatus::Incomplete;

$status->notIn([TaskStatus::Incomplete, TaskStatus::Completed]); // false
$status->notIn([TaskStatus::Completed, TaskStatus::Canceled]); // true

$role = Role::Administrator;
$role->notIn([Role::Administrator, Role::Guest]); // false
$role->notIn([Role::Subscriber, Role::Guest]); // true
```

## Use Cases

### State Machine Logic

```php
class Task
{
    public function canTransition(TaskStatus $to): bool
    {
        return match($this->status) {
            TaskStatus::Incomplete => $to->in([
                TaskStatus::Completed,
                TaskStatus::Canceled
            ]),
            TaskStatus::Completed => $to->is(TaskStatus::Incomplete),
            TaskStatus::Canceled => false,
        };
    }
}
```

### Permission Checks

```php
class UserController
{
    public function edit(User $user)
    {
        if ($user->role->isNot(Role::Administrator)) {
            abort(403);
        }

        // Edit logic...
    }
}
```

### Filtering Collections

```php
$activeTasks = $tasks->filter(function ($task) {
    return $task->status->notIn([
        TaskStatus::Completed,
        TaskStatus::Canceled
    ]);
});
```

### Conditional Rendering

```php
@if($order->status->in([OrderStatus::Pending, OrderStatus::Processing]))
    <button>Cancel Order</button>
@endif

@if($user->role->is(Role::Administrator))
    <a href="/admin">Admin Panel</a>
@endif
```

### Validation Rules

```php
public function rules(): array
{
    return [
        'status' => [
            'required',
            function ($attribute, $value, $fail) {
                $status = TaskStatus::tryFrom($value);

                if (!$status || $status->in([TaskStatus::Archived, TaskStatus::Deleted])) {
                    $fail('The selected status is invalid.');
                }
            }
        ]
    ];
}
```

## Benefits

The Comparable trait provides cleaner syntax than native PHP comparisons:

1. **Improved readability** - `$status->is(TaskStatus::Completed)` vs `$status === TaskStatus::Completed`
2. **Simplified array operations** - `in()` and `notIn()` replace verbose `in_array()` calls
3. **Chainable conditions** - Compose complex logic flows efficiently
4. **Consistent API** - Aligns with patterns from other libraries and frameworks
