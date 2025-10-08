<p align="center">
    <a href="https://github.com/faustbrian/enums/actions"><img alt="GitHub Workflow Status (master)" src="https://github.com/faustbrian/enums/actions/workflows/tests.yml/badge.svg"></a>
    <a href="https://packagist.org/packages/cline/enums"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/cline/enums"></a>
    <a href="https://packagist.org/packages/cline/enums"><img alt="Latest Version" src="https://img.shields.io/packagist/v/cline/enums"></a>
    <a href="https://packagist.org/packages/cline/enums"><img alt="License" src="https://img.shields.io/packagist/l/cline/enums"></a>
</p>

------

A collection of enum helpers for PHP that enhance native PHP enums with powerful features and utilities.

## Requirements

> **Requires [PHP 8.4+](https://php.net/releases/)**

## Installation

```bash
composer require cline/enums
```

## Documentation

- **[Getting Started](cookbook/getting-started.md)** - Installation and basic usage
- **[InvokableCases](cookbook/invokable-cases.md)** - Get enum values without ->value
- **[Collections](cookbook/collections.md)** - Names, values, and options methods
- **[Instantiation](cookbook/instantiation.md)** - Enhanced from() and fromName() methods
- **[Metadata](cookbook/metadata.md)** - Add custom properties to enum cases
- **[Comparable](cookbook/comparable.md)** - Compare enum instances with is(), in()

## Highlights

- Get enum values by invoking cases like methods
- Retrieve lists of names, values, and options for forms
- Add custom metadata to enum cases using attributes
- Compare enum instances with readable methods
- Enhanced instantiation from names and values
- Full IDE support with PHPStan extensions

## Quick Reference

### Core Features

- **InvokableCases**: Use `MyEnum::FOO()` instead of `MyEnum::FOO->value`
- **Names & Values**: Get all case names or values as arrays
- **Options**: Generate form-ready arrays and HTML options
- **Metadata**: Attach custom properties to cases with attributes
- **Comparable**: Use `->is()`, `->in()` for readable comparisons
- **From**: Create instances from names with `fromName()`

### Common Patterns

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

See the [cookbook](cookbook/) for detailed examples.

## Development

**Lint code with PHP CS Fixer:**
```bash
composer lint
```

**Run refactors with Rector:**
```bash
composer refactor
```

**Run static analysis with PHPStan:**
```bash
composer test:types
```

**Run unit tests with PEST:**
```bash
composer test:unit
```

**Run the entire test suite:**
```bash
composer test
```

**Code style:** Automatically fixed by php-cs-fixer.

## Credits

**Enums** was created by **[Brian Faust](https://github.com/faustbrian)** under the **[MIT license](https://opensource.org/licenses/MIT)**.

> This package is based on the original work from **[archtechx/enums](https://github.com/archtechx/enums)**.
