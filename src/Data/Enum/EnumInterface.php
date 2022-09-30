<?php

declare(strict_types=1);

namespace App\Data\Enum;

interface EnumInterface
{
    public static function getName(): string;

    public static function getOptions(): array;
}
