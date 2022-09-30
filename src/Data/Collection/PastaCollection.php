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

    public function get(string $key): ?PastaDataInterface
    {
        return $this->data[$key] ?? null;
    }

    public function add(PastaDataInterface $pasta): void
    {
        $this->data[$pasta::getName()] = $pasta;
    }

    public function getNames(): array
    {
        $names = [];
        foreach($this->data as $name => $class) {
            $names[$name] = $class->getPrettyName();
        }

        return $names;
    }
}
