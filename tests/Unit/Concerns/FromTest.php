<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tests\Fixtures\Role;
use Tests\Fixtures\Status;

describe('From Concern', function (): void {
    describe('Happy Paths', function (): void {
        describe('BackedEnum from() method', function (): void {
            test('returns enum case when given valid backing value', function (): void {
                // Arrange & Act
                $result = Status::from(0);

                // Assert
                expect($result)->toBe(Status::PENDING);
            });

            test('does not override native BackedEnum from method', function (): void {
                // Arrange & Act
                $result = Status::from(0);

                // Assert
                expect($result)->toBe(Status::PENDING);
            });
        });

        describe('BackedEnum tryFrom() method', function (): void {
            test('returns enum case when given valid backing value', function (): void {
                // Arrange & Act
                $result = Status::tryFrom(1);

                // Assert
                expect($result)->toBe(Status::DONE);
            });

            test('returns null when given invalid backing value', function (): void {
                // Arrange & Act
                $result = Status::tryFrom(2);

                // Assert
                expect($result)->toBeNull();
            });
        });

        describe('Pure enum from() method', function (): void {
            test('selects case by name for pure enums', function (): void {
                // Arrange & Act
                $result = Role::from('ADMIN');

                // Assert
                expect($result)->toBe(Role::ADMIN);
            });
        });

        describe('Pure enum tryFrom() method', function (): void {
            test('selects case by name for pure enums', function (): void {
                // Arrange & Act
                $result = Role::tryFrom('GUEST');

                // Assert
                expect($result)->toBe(Role::GUEST);
            });

            test('returns null when selecting non-existent case for pure enums', function (): void {
                // Arrange & Act
                $result = Role::tryFrom('NOBODY');

                // Assert
                expect($result)->toBeNull();
            });
        });

        describe('fromName() method', function (): void {
            test('selects case by name for pure enums', function (): void {
                // Arrange & Act
                $result = Role::fromName('ADMIN');

                // Assert
                expect($result)->toBe(Role::ADMIN);
            });

            test('selects case by name for backed enums', function (): void {
                // Arrange & Act
                $result = Status::fromName('PENDING');

                // Assert
                expect($result)->toBe(Status::PENDING);
            });
        });

        describe('tryFromName() method', function (): void {
            test('selects case by name for pure enums', function (): void {
                // Arrange & Act
                $result = Role::tryFromName('GUEST');

                // Assert
                expect($result)->toBe(Role::GUEST);
            });

            test('returns null when selecting non-existent case for pure enums', function (): void {
                // Arrange & Act
                $result = Role::tryFromName('NOBODY');

                // Assert
                expect($result)->toBeNull();
            });

            test('selects case by name for backed enums', function (): void {
                // Arrange & Act
                $result = Status::tryFromName('DONE');

                // Assert
                expect($result)->toBe(Status::DONE);
            });

            test('returns null when selecting non-existent case for backed enums', function (): void {
                // Arrange & Act
                $result = Status::tryFromName('NOTHING');

                // Assert
                expect($result)->toBeNull();
            });
        });
    });

    describe('Sad Paths', function (): void {
        // Shortened exception message due to inconsistency between PHP 8.1 and 8.2+
        // 8.1:  2 is not a valid backing value for enum "Status"
        // 8.2+: 2 is not a valid backing value for enum Status
        test('from method throws ValueError for invalid backing value on backed enums', function (): void {
            // Arrange & Act & Assert
            Status::from(2);
        })->throws(ValueError::class, '2 is not a valid backing value for enum');

        test('from method throws ValueError for non-existent case name on pure enums', function (): void {
            // Arrange & Act & Assert
            Role::from('NOBODY');
        })->throws(ValueError::class, '"NOBODY" is not a valid name for enum Role');

        test('fromName method throws ValueError for non-existent case on pure enums', function (): void {
            // Arrange & Act & Assert
            Role::fromName('NOBODY');
        })->throws(ValueError::class, '"NOBODY" is not a valid name for enum Role');

        test('fromName method throws ValueError for non-existent case on backed enums', function (): void {
            // Arrange & Act & Assert
            Status::fromName('NOTHING');
        })->throws(ValueError::class, '"NOTHING" is not a valid name for enum Status');
    });
});
