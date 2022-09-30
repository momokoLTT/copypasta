<?php

declare(strict_types=1);

namespace App\Data;

interface PastaDataInterface
{
    public static function getName(): string;

    /** the Pretty name gets used as a field value for the form where you select your pasta. */
    public function getPrettyName(): string;

    public function getBaseText(): string;

    public function getDefaultValues(): array;

    public function sanitizeInput(array $input): array;

    public function getChoicesFor(string $key): ?array;
}
