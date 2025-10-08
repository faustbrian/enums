<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tests\Fixtures\BackedMultiWordSnakeCaseEnum;
use Tests\Fixtures\BackedPascalCaseEnum;
use Tests\Fixtures\MultiWordSnakeCaseEnum;
use Tests\Fixtures\PascalCaseEnum;
use Tests\Fixtures\Role;
use Tests\Fixtures\Status;

describe('Options Concern', function (): void {
    describe('Happy Paths', function (): void {
        describe('Array options', function (): void {
            test('returns associative array of options from backed enum', function (): void {
                // Arrange & Act
                $options = Status::options();

                // Assert
                expect($options)->toBe([
                    'PENDING' => 0,
                    'DONE' => 1,
                ]);
            });

            test('returns indexed array of options from pure enum', function (): void {
                // Arrange & Act
                $options = Role::options();

                // Assert
                expect($options)->toBe([
                    0 => 'ADMIN',
                    1 => 'GUEST',
                ]);
            });
        });

        describe('String options with custom formatting', function (): void {
            test('returns custom formatted string from backed enum', function (): void {
                // Arrange
                $formatter = fn ($name, $value) => "{$name} => {$value}";

                // Act
                $result = Status::stringOptions($formatter, ', ');

                // Assert
                expect($result)->toBe('PENDING => 0, DONE => 1');
            });

            test('returns custom formatted string from pure enum', function (): void {
                // Arrange
                $formatter = fn ($name, $value) => "{$name} => {$value}";

                // Act
                $result = Role::stringOptions($formatter, ', ');

                // Assert
                expect($result)->toBe('ADMIN => ADMIN, GUEST => GUEST');
            });
        });

        describe('Default HTML options', function (): void {
            test('returns HTML options from backed enums', function (): void {
                // Arrange & Act
                $html = Status::stringOptions();

                // Assert
                expect($html)->toBe('<option value="0">Pending</option>\n<option value="1">Done</option>');
            });

            test('returns HTML options from pure enums', function (): void {
                // Arrange & Act
                $html = Role::stringOptions();

                // Assert
                expect($html)->toBe('<option value="ADMIN">Admin</option>\n<option value="GUEST">Guest</option>');
            });
        });

        describe('HTML options with case name formatting', function (): void {
            test('returns HTML options from pure enums with snake case', function (): void {
                // Arrange & Act
                $html = MultiWordSnakeCaseEnum::stringOptions();

                // Assert
                expect($html)->toBe('<option value="FOO_BAR">Foo bar</option>\n<option value="BAR_BAZ">Bar baz</option>');
            });

            test('returns HTML options from backed enums with snake case', function (): void {
                // Arrange & Act
                $html = BackedMultiWordSnakeCaseEnum::stringOptions();

                // Assert
                expect($html)->toBe('<option value="0">Foo bar</option>\n<option value="1">Bar baz</option>');
            });

            test('returns HTML options from pure enums with pascal case', function (): void {
                // Arrange & Act
                $html = PascalCaseEnum::stringOptions();

                // Assert
                expect($html)->toBe('<option value="FooBar">Foo bar</option>\n<option value="BarBaz">Bar baz</option>');
            });

            test('returns HTML options from backed enums with pascal case', function (): void {
                // Arrange & Act
                $html = BackedPascalCaseEnum::stringOptions();

                // Assert
                expect($html)->toBe('<option value="0">Foo bar</option>\n<option value="1">Bar baz</option>');
            });
        });
    });
});
