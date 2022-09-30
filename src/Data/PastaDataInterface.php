<?php

declare(strict_types=1);

namespace App\Data;

interface PastaDataInterface
{
    public static function getName(): string;

    public function getBaseText(): string;

    public function getDefaultValues(): array;

    public function sanitizeInput(array $input): array;
}
