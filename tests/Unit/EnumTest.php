<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\Enums\Concerns\Comparable;
use Cline\Enums\Concerns\From;
use Cline\Enums\Concerns\InvokableCases;
use Cline\Enums\Concerns\Metadata;
use Cline\Enums\Concerns\Names;
use Cline\Enums\Concerns\Options;
use Cline\Enums\Concerns\Values;
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
            expect($traits)->toHaveKey(Comparable::class);
            expect($traits)->toHaveKey(From::class);
            expect($traits)->toHaveKey(InvokableCases::class);
            expect($traits)->toHaveKey(Metadata::class);
            expect($traits)->toHaveKey(Names::class);
            expect($traits)->toHaveKey(Options::class);
            expect($traits)->toHaveKey(Values::class);
        });
    });
});
