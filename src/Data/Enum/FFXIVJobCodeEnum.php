<?php

declare(strict_types=1);

namespace App\Data\Enum;

class FFXIVJobCodeEnum extends AbstractEnum
{
    public static function getOptions(): array
    {
        return [
            'PLD',
            'WAR',
            'DRK',
            'GNB',
            'WHM',
            'SCH',
            'AST',
            'SGE',
            'MNK',
            'DRG',
            'NIN',
            'SAM',
            'RPR',
            'BRD',
            'MCH',
            'DNC',
            'BLM',
            'SMN',
            'RDM',
            'BLU',
        ];
    }

    public static function getName(): string
    {
        return 'enumJobCode';
    }
}