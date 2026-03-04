<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tests\Fixtures\Color;
use Tests\Fixtures\Config;
use Tests\Fixtures\Desc;
use Tests\Fixtures\Feature;
use Tests\Fixtures\Instructions;
use Tests\Fixtures\ReferenceType;
use Tests\Fixtures\Role;
use Tests\Fixtures\RoleWithoutAttribute;
use Tests\Fixtures\Status;

describe('Metadata Concern', function (): void {
    describe('Happy Paths', function (): void {
        describe('Metadata on enum cases', function (): void {
            test('pure enums can have metadata on cases', function (): void {
                // Arrange
                $admin = Role::ADMIN;
                $guest = Role::GUEST;

                // Act & Assert
                expect($admin->color())->toBe('indigo');
                expect($guest->color())->toBe('gray');
                expect($admin->description())->toBe('Administrator');
                expect($guest->description())->toBe('Read-only guest');
                expect($admin->help())->toBe('Help: Administrators can manage the entire account');
                expect($guest->help())->toBe('Help: Guest users can only view the existing records');
            });

            test('backed enums can have metadata on cases', function (): void {
                // Arrange
                $done = Status::DONE;
                $pending = Status::PENDING;

                // Act & Assert
                expect($done->color())->toBe('green');
                expect($pending->color())->toBe('orange');
                expect($pending->description())->toBe('Incomplete task');
                expect($done->description())->toBe('Completed task');
            });
        });

        describe('Metadata method name customization', function (): void {
            test('customizes method name using method', function (): void {
                // Arrange & Act
                $methodName = Desc::method();
                $doneDescription = Status::DONE->description();

                // Assert
                expect($methodName)->toBe('description');
                expect($doneDescription)->not()->toBeNull();
            });

            test('customizes method name using property', function (): void {
                // Arrange & Act
                $methodName = Instructions::method();
                $adminHelp = Role::ADMIN->help();

                // Assert
                expect($methodName)->toBe('help');
                expect($adminHelp)->not()->toBeNull();
            });
        });

        describe('Metadata transformations', function (): void {
            test('transforms arguments in metadata', function (): void {
                // Arrange & Act
                $instructions = Instructions::make('Administrators can manage the entire account');

                // Assert
                expect($instructions->value)->toStartWith('Help: ');
            });
        });

        describe('Enum instantiation from metadata', function (): void {
            test('instantiates enum from metadata using fromMeta', function (): void {
                // Arrange
                $indigoColor = Color::make('indigo');
                $grayColor = Color::make('gray');
                $incompleteDesc = Desc::make('Incomplete task');
                $completedDesc = Desc::make('Completed task');

                // Act
                $adminRole = Role::fromMeta($indigoColor);
                $guestRole = Role::fromMeta($grayColor);
                $pendingStatus = Status::fromMeta($incompleteDesc);
                $doneStatus = Status::fromMeta($completedDesc);

                // Assert
                expect($adminRole)->toBe(Role::ADMIN);
                expect($guestRole)->toBe(Role::GUEST);
                expect($pendingStatus)->toBe(Status::PENDING);
                expect($doneStatus)->toBe(Status::DONE);
            });

            test('instantiates enum from metadata using tryFromMeta', function (): void {
                // Arrange
                $indigoColor = Color::make('indigo');

                // Act
                $result = Role::tryFromMeta($indigoColor);

                // Assert
                expect($result)->toBe(Role::ADMIN);
            });
        });

        describe('Metadata default values', function (): void {
            test('uses default values when metadata not set', function (): void {
                // Arrange
                $inactiveType = ReferenceType::INACTIVE_TYPE;

                // Act
                $isActive = $inactiveType->isActive();

                // Assert
                expect($isActive)->toBeFalse();
            });
        });
    });

    describe('Sad Paths', function (): void {
        test('fromMeta throws ValueError when enum cannot be instantiated', function (): void {
            // Arrange
            $invalidColor = Color::make('foobar');

            // Act & Assert
            Role::fromMeta($invalidColor);
        })->throws(ValueError::class, 'Enum Role does not have a case with a meta property "Color" of value "foobar"');

        test('fromMeta throws ValueError with json encoded value for non-scalar metadata', function (): void {
            // Arrange
            $invalidConfig = Config::make(['enabled' => true, 'limit' => 999]);

            // Act & Assert
            Feature::fromMeta($invalidConfig);
        })->throws(ValueError::class, 'Enum Feature does not have a case with a meta property "Config" of value "{"enabled":true,"limit":999}"');
    });

    describe('Edge Cases', function (): void {
        test('returns null when meta property not enabled on enum', function (): void {
            // Arrange
            $done = Status::DONE;

            // Act
            $help = $done->help();

            // Assert
            expect($help)->toBeNull(); // not enabled
        });

        test('returns null when accessing non-customized metadata method name', function (): void {
            // Arrange
            $done = Status::DONE;
            $admin = Role::ADMIN;

            // Act
            $doneDesc = $done->desc();
            $adminInstructions = $admin->instructions();

            // Assert
            expect($doneDesc)->toBeNull();
            expect($adminInstructions)->toBeNull();
        });

        test('tryFromMeta returns null when enum cannot be instantiated', function (): void {
            // Arrange
            $invalidColor = Color::make('foobar');

            // Act
            $result = Role::tryFromMeta($invalidColor);

            // Assert
            expect($result)->toBeNull();
        });

        test('returns null when metadata property missing on case', function (): void {
            // Arrange
            $adminWithoutAttribute = RoleWithoutAttribute::ADMIN;

            // Act
            $desc = $adminWithoutAttribute->desc();

            // Assert
            expect($desc)->toBeNull();
        });
    });
});
