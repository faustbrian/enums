# Getting Started

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

- **[InvokableCases](invokable-cases.md)** - Get enum values by invoking cases
- **[Names](collections.md#names)** - Get list of case names
- **[Values](collections.md#values)** - Get list of case values
- **[Options](collections.md#options)** - Get associative arrays for forms
- **[From](instantiation.md)** - Enhanced instantiation methods
- **[Metadata](metadata.md)** - Add custom properties to cases
- **[Comparable](comparable.md)** - Compare enum instances
