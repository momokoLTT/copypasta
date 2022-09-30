<?php

declare(strict_types=1);

namespace App\Data\Enum;

class FFXIVJobNameEnum extends AbstractEnum
{
    public static function getOptions(): array
    {
        return [
            'paladin',
            'warrior',
            'dark knight',
            'gunbreaker',
            'white mage',
            'scholar',
            'astrologian',
            'sage',
            'monk',
            'dragoon',
            'ninja',
            'samurai',
            'reaper',
            'bard',
            'machinist',
            'dancer',
            'black mage',
            'summoner',
            'red mage',
            'blue mage',
        ];
    }

    public static function getName(): string
    {
        return 'enumJobName';
    }
}