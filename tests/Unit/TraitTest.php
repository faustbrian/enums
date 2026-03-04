<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tests\Fixtures\MyEnum;

describe('Trait Usage', function (): void {
    describe('Happy Paths', function (): void {
        test('returns meta property values when defined on enum case', function (): void {
            // Arrange
            $fooCase = MyEnum::FOO;
            $barCase = MyEnum::BAR;

            // Act
            $fooDescription = $fooCase->description();
            $barDescription = $barCase->description();

            // Assert
            expect($fooDescription)->toBe('Foo!');
            expect($barDescription)->toBe('Bar!');
        });
    });

    describe('Edge Cases', function (): void {
        test('returns null when meta property not defined on enum case', function (): void {
            // Arrange
            $bazCase = MyEnum::BAZ;

            // Act
            $bazDescription = $bazCase->description();

            // Assert
            expect($bazDescription)->toBeNull();
        });
    });
});
