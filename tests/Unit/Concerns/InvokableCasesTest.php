<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\Enums\Exceptions\UndefinedCaseError;
use Tests\Fixtures\Role;
use Tests\Fixtures\Status;

describe('InvokableCases Concern', function (): void {
    describe('Happy Paths', function (): void {
        describe('Static method invocation', function (): void {
            test('invokes backed enum case as static method returning value', function (): void {
                // Arrange & Act
                $pendingValue = Status::PENDING();
                $doneValue = Status::DONE();

                // Assert
                expect($pendingValue)->toBe(0);
                expect($doneValue)->toBe(1);
            });

            test('invokes pure enum case as static method returning name', function (): void {
                // Arrange & Act
                $adminValue = Role::ADMIN();
                $guestValue = Role::GUEST();

                // Assert
                expect($adminValue)->toBe('ADMIN');
                expect($guestValue)->toBe('GUEST');
            });
        });

        describe('Instance invocation', function (): void {
            test('invokes backed enum instance returning backing value', function (): void {
                // Arrange
                $status = Status::PENDING;

                // Act
                $result = $status();

                // Assert
                expect($result)->toBe(0);
                expect($result)->toBe($status->value);
            });

            test('invokes pure enum instance returning case name', function (): void {
                // Arrange
                $role = Role::ADMIN;

                // Act
                $result = $role();

                // Assert
                expect($result)->toBe('ADMIN');
            });
        });
    });

    describe('Sad Paths', function (): void {
        test('throws UndefinedCaseError when invoking non-existent backed enum case', function (): void {
            // Arrange & Act & Assert
            Status::INVALID();
        })->expectException(UndefinedCaseError::class);

        test('throws UndefinedCaseError when invoking non-existent pure enum case', function (): void {
            // Arrange & Act & Assert
            Role::INVALID();
        })->expectException(UndefinedCaseError::class);
    });
});
