<?php

declare(strict_types=1);

namespace App\Data\Collection;

use App\Data\Enum\AbstractEnum;

class EnumCollection
{
    /**
     * @var array<AbstractEnum>
     */
    private array $data;

    public function get(string $key): ?AbstractEnum
    {
        return $this->data[$key] ?? null;
    }

    public function add(AbstractEnum $enum): void
    {
        $this->data[$enum::getName()] = $enum;
    }
}
