<?php

declare(strict_types=1);

namespace App\Service;

use App\Data\Collection\PastaCollection;
use RuntimeException;

class PastaService
{
    public function __construct(private PastaCollection $pastas)
    {
    }

    public function createPasta(string $key, array $replacements = []): string
    {
        $dataClass = $this->pastas->get($key);
        if (!$dataClass) {
            throw new RuntimeException("Unable to find class for key $key");
        }

        $text = $dataClass->getBaseText();
        $replacements = array_merge(
            $dataClass->getDefaultValues(),
            $dataClass->sanitizeInput($replacements),
        );

        foreach ($replacements as $find => $replace) {
            $isAllCaps = preg_match_all("/[A-Z\s]/", $replace) === strlen($replace);

            $lowercaseReplace = $isAllCaps ? strtoupper($replace) : strtolower($replace);
            $uppercaseReplace = $isAllCaps ? strtoupper($replace) : ucwords($replace);

            $text = str_replace(
                [";${find};", ":${find}:"],
                [$lowercaseReplace, $uppercaseReplace],
                $text
            );
        }

        return $text;
    }
}
