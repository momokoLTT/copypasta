<?php

declare(strict_types=1);

namespace App\Data\Enum;

class FFXIVJobEnum
{
    public const KEY = 'enumJobName';
    public const CHOICES = [
        'PLD' => 'paladin',
        'WAR' => 'warrior',
        'DRK' => 'dark knight',
        'GNB' => 'gunbreaker',
        'WHM' => 'white mage',
        'SCH' => 'scholar',
        'AST' => 'astrologian',
        'SGE' => 'sage',
        'MNK' => 'monk',
        'DRG' => 'dragoon',
        'NIN' => 'ninja',
        'SAM' => 'samurai',
        'RPR' => 'reaper',
        'BRD' => 'bard',
        'MCH' => 'machinist',
        'DNC' => 'dancer',
        'BLM' => 'black mage',
        'SMN' => 'summoner',
        'RDM' => 'red mage',
        'BLU' => 'blue mage',
    ];
}