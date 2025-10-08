<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tests\Fixtures\ConcreteEnum;

describe('Base Enum Class', function (): void {
    describe('Happy Paths', function (): void {
        test('can be extended to create fully-featured enum', function (): void {
            // Arrange & Act
            $enumClass = ConcreteEnum::class;

            // Assert
            expect($enumClass)->toBeString();
        });

        test('includes all required traits when extended', function (): void {
            // Arrange & Act
            $traits = class_uses_recursive(ConcreteEnum::class);

            // Assert
            expect($traits)->toHaveKey('Cline\Enums\Concerns\Comparable');
            expect($traits)->toHaveKey('Cline\Enums\Concerns\From');
            expect($traits)->toHaveKey('Cline\Enums\Concerns\InvokableCases');
            expect($traits)->toHaveKey('Cline\Enums\Concerns\Metadata');
            expect($traits)->toHaveKey('Cline\Enums\Concerns\Names');
            expect($traits)->toHaveKey('Cline\Enums\Concerns\Options');
            expect($traits)->toHaveKey('Cline\Enums\Concerns\Values');
        });
    });
});
