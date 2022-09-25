<?php

declare(strict_types=1);

namespace App\Service;

use App\Data\PastaDataInterface;
use App\Data\YouKnowWhatData;
use RuntimeException;

class PastaService
{
    // TODO: dynamically fill this instead of hardcoding it
    private const CLASSES = [
        YouKnowWhatData::KEY => YouKnowWhatData::class,
    ];

    public function createPasta(string $key, array $replacements = []): string
    {
        /** @var PastaDataInterface $dataClass */
        $dataClass = self::CLASSES[$key];
        if (!$dataClass) {
            throw new RuntimeException("Unable to find class for key $key");
        }

        $text = $dataClass::TEXT;
        $replacements = $dataClass::sanitizeInput($replacements);
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
