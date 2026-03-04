<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tests\Fixtures\Role;
use Tests\Fixtures\Status;

describe('Values Concern', function (): void {
    describe('Happy Paths', function (): void {
        test('returns array of backing values from backed enum', function (): void {
            // Arrange & Act
            $values = Status::values();

            // Assert
            expect($values)->toBe([0, 1]);
        });

        test('returns array of case names from pure enum', function (): void {
            // Arrange & Act
            $values = Role::values();

            // Assert
            expect($values)->toBe(['ADMIN', 'GUEST']);
        });
    });
});
