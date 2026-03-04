<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tests\Fixtures\Role;
use Tests\Fixtures\Status;

describe('Names Concern', function (): void {
    describe('Happy Paths', function (): void {
        test('returns array of case names from backed enums', function (): void {
            // Arrange & Act
            $names = Status::names();

            // Assert
            expect($names)->toBe(['PENDING', 'DONE']);
        });

        test('returns array of case names from pure enums', function (): void {
            // Arrange & Act
            $names = Role::names();

            // Assert
            expect($names)->toBe(['ADMIN', 'GUEST']);
        });
    });
});
