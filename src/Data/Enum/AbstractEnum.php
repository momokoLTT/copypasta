<?php

declare(strict_types=1);

namespace App\Data\Enum;

abstract class AbstractEnum implements EnumInterface
{
    abstract public static function getOptions(): array;

    public function isAllowed(mixed $value): bool
    {
        return in_array($value, $this::getOptions(), true);
    }
}
