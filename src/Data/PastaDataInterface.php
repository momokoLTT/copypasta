<?php

declare(strict_types=1);

namespace App\Data;

interface PastaDataInterface {
    public static function createPasta(array $replacements = []): string;
}
