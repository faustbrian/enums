<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tests\Fixtures\Role;
use Tests\Fixtures\Status;

describe('Comparable Concern', function (): void {
    describe('Happy Paths', function (): void {
        test('is method returns true when comparing identical enum cases', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $adminRole = Role::ADMIN;

            // Act & Assert
            expect($pendingStatus->is(Status::PENDING))->toBeTrue();
            expect($adminRole->is(Role::ADMIN))->toBeTrue();
        });

        test('is method returns false when comparing different enum cases', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $adminRole = Role::ADMIN;

            // Act & Assert
            expect($pendingStatus->is(Status::DONE))->toBeFalse();
            expect($adminRole->is(Role::GUEST))->toBeFalse();
        });

        test('isNot method returns true when comparing different enum cases', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $adminRole = Role::ADMIN;

            // Act & Assert
            expect($pendingStatus->isNot(Status::DONE))->toBeTrue();
            expect($adminRole->isNot(Role::GUEST))->toBeTrue();
        });

        test('isNot method returns false when comparing identical enum cases', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $adminRole = Role::ADMIN;

            // Act & Assert
            expect($pendingStatus->isNot(Status::PENDING))->toBeFalse();
            expect($adminRole->isNot(Role::ADMIN))->toBeFalse();
        });

        test('in method returns true when enum present in array', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $adminRole = Role::ADMIN;
            $statusArray = [Status::PENDING, Status::DONE];
            $roleArray = [Role::ADMIN];

            // Act & Assert
            expect($pendingStatus->in($statusArray))->toBeTrue();
            expect($adminRole->in($roleArray))->toBeTrue();
        });

        test('in method returns true when enum present in iterator', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $doneStatus = Status::DONE;
            $iterator = new ArrayIterator([Status::PENDING, Status::DONE]);

            // Act & Assert
            expect($pendingStatus->in($iterator))->toBeTrue();
            expect($doneStatus->in($iterator))->toBeTrue();
        });

        test('in method works with laravel collections', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $collection = collect([Status::PENDING, Status::DONE]);

            // Act & Assert
            expect($pendingStatus->in($collection))->toBeTrue();
        });

        test('notIn method returns true when enum absent from array', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $adminRole = Role::ADMIN;
            $statusArray = [Status::DONE];
            $roleArray = [Role::GUEST];

            // Act & Assert
            expect($pendingStatus->notIn($statusArray))->toBeTrue();
            expect($adminRole->notIn($roleArray))->toBeTrue();
        });

        test('notIn method works with laravel collections', function (): void {
            // Arrange
            $doneStatus = Status::DONE;
            $collection = collect([Status::PENDING]);

            // Act & Assert
            expect($doneStatus->notIn($collection))->toBeTrue();
        });
    });

    describe('Sad Paths', function (): void {
        test('is method returns false when comparing enum to string value', function (): void {
            // Arrange
            $adminRole = Role::ADMIN;

            // Act & Assert
            expect($adminRole->is('admin'))->toBeFalse();
        });

        test('isNot method returns true when comparing enum to string value', function (): void {
            // Arrange
            $adminRole = Role::ADMIN;

            // Act & Assert
            expect($adminRole->isNot('admin'))->toBeTrue();
        });

        test('in method returns false when enum not in array', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $arrayWithoutPending = [Status::DONE];

            // Act & Assert
            expect($pendingStatus->in($arrayWithoutPending))->toBeFalse();
        });

        test('in method returns false when comparing different enum types', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $roleArray = [Role::ADMIN, Role::GUEST];

            // Act & Assert
            expect($pendingStatus->in($roleArray))->toBeFalse();
        });

        test('in method returns false when enum not in iterator', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $iterator = new ArrayIterator([Role::ADMIN, Role::GUEST]);

            // Act & Assert
            expect($pendingStatus->in($iterator))->toBeFalse();
        });

        test('in method returns false with laravel collection of different enum type', function (): void {
            // Arrange
            $adminRole = Role::ADMIN;
            $collection = collect([Status::PENDING, Role::GUEST]);

            // Act & Assert
            expect($adminRole->in($collection))->toBeFalse();
        });

        test('notIn method returns false when enum present in array', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $adminRole = Role::ADMIN;
            $statusArray = [Status::PENDING, Status::DONE];
            $roleArray = [Role::ADMIN, Role::GUEST];

            // Act & Assert
            expect($pendingStatus->notIn($statusArray))->toBeFalse();
            expect($adminRole->notIn($roleArray))->toBeFalse();
        });

        test('notIn method returns false with laravel collection containing enum', function (): void {
            // Arrange
            $adminRole = Role::ADMIN;
            $collection = collect([Role::ADMIN, Status::PENDING]);

            // Act & Assert
            expect($adminRole->notIn($collection))->toBeFalse();
        });
    });

    describe('Edge Cases', function (): void {
        test('isNot method returns true when comparing different enum types', function (): void {
            // Arrange
            $pendingStatus = Status::PENDING;
            $adminRole = Role::ADMIN;

            // Act & Assert
            expect($pendingStatus->isNot($adminRole))->toBeTrue();
        });
    });
});
