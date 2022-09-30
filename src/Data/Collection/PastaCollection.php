<?php

declare(strict_types=1);

namespace App\Data\Collection;

use App\Data\PastaDataInterface;

class PastaCollection
{
    /**
     * @var array<PastaDataInterface>
     */
    private array $data;

    public function getPasta(string $key)
    {
        return $this->data[$key];
    }

    public function addPasta(PastaDataInterface $pasta)
    {
        $this->data[$pasta::getName()] = $pasta;
    }
}
