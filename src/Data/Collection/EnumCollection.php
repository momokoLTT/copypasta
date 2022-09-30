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

    public function getEnum(string $key)
    {
        return $this->data[$key];
    }

    public function addEnum(AbstractEnum $enum)
    {
        $this->data[$enum::getName()] = $enum;
    }
}
