<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\Enum\FFXIVJobEnum;

class YouKnowWhatData implements PastaDataInterface
{
    public const KEY = 'you-know-what-nia';

    public const REPLACEMENTS = [
        'goodHealerName' => 'Nia',
        'goodHealerAbility1' => 'adloquium',

        'badHealerName' => 'Katalena',
        'badHealerJob' => 'white mage',
        'badHealerAbility1' => 'Medica II',

        'jobType' => 'healer',
        'castOrUse' => 'cast',
        'healOrSpellOrSkill' => 'heal',
        'regenOrShieldOrMit' => 'regen',
        'wipeCause' => 'healing',
    ];

    public const TEXT = <<< PASTA
You know what? You know what I want? I want the person who carried the past fucking 500 pulls to have the weapon so you know what? :goodHealerName: can have the fucking weapon. :goodHealerName: can have the goddamn fucking weapon. You know who else can have the mount too? :goodHealerName: can have the mount too. And you know who can have the minion? :goodHealerName: can have the fucking minion too. And you know who can have the fucking orchestrion roll? :goodHealerName: can have the orchestrion roll too. End of story, have a goodnight everyone, goodbye.
:badHealerName: you are the greediest piece of shit ;jobType; I have ever played with in my entire fucking life. You can not ;castOrUse; a :badHealerAbility1: for the fucking life of you, Jesus fucking Christ think of the fucking raid and stop parsing zero on healing. You absolute fucking selfish asshole dumb-fuck, you say "I don't care about parsing, I don't have the weapon anyway" then what the fuck are you doing? :castOrUse: a fucking ;healOrSpellOrSkill;, Jesus Christ you're so fucking selfish and stupid. Look at :goodHealerName:, ;castOrUse;ing 50 fucking :goodHealerAbility1:s or whatever, just to keep the people with the DOTs alive because you can't give them a fucking ;regenOrShieldOrMit;, or you can't ;castOrUse; a fucking :badHealerAbility1:, holy shit are you that fucking stupid? And your damage doesn't even fucking make up for it, your damage is fucking shit for how much you fucking grief the entire party. Holy shit, I made a fucking video compilation of all the times that we died to ;wipeCause;, you can say "oh we died to mechanics more than we died to ;wipeCause;!" But we shouldn't have died to ;wipeCause;, a single goddamn fucking time. If you just healed the fucking party instead of being a fucking, idiot, fucking asshole holy shit. You are so fucking stupid, oh my god. How hard is it to fucking ;castOrUse; a :badHealerAbility1: you fucking dumbass, holy shit. Do you just not want to clear? You told me "I don't want to spend any excessive time in reclears this week because that would be dumb. That's why I don't want to try the uptime strats." Then why don't you ;castOrUse; a fucking ;healOrSpellOrSkill; instead of being fucking stupid. Yeah leave voice chat you fucking pussy, Jesus Christ this static is done. Goodnight everyone. Congratulations to everyone that got loot, thank you for coming. I love all of you except :badHealerName:, :badHealerName: can go fuck themselves and die.
Shut the fuck up. I'm talking. I'm talking. You let them walk all over you and that just gives rubs me the wrong way. I can't believe you let your friend do you to you like that. I genuinely feel bad for you and hope you find something better. And I hope :badHealerName: goes and fucks themselves in a new group. And I hope that you world prog cause you're one of the best damn healers I've ever fucking played with in my entire life. You're so fucking good. You rarely made mistakes and you healed so much. Holy shit, you are so good. Please find a static that is as good as you. Holy shit, cause you're not gonna find it here cause you're better than me. And I played like shit this tier, and even if played at my absolute best like I played in DSR you woulda been 10 times better than me, you are so good. So find a good static, please. not with them. Not with that greedy ass ;badHealerJob;. Jesus Christ. Ok, good night everyone. I'm done. This group is done. Find a new group for reclears. Thank you everyone for coming.
PASTA;

    /**
     * @param array<string,string> $input
     *
     * @return array<string,string>
     */
    public static function sanitizeInput(array $input): array
    {
        $sanitizedInput = [];
        foreach (self::REPLACEMENTS as $key => $defaultValue) {
            if (!$input[$key]) {
                continue;
            }

            if ($key === 'jobType'
                && !in_array($input[$key], ['healer', 'tank', 'dps'])
            ) {
                continue;
            }

            if ($key === 'badHealerJob'
                && !array_key_exists($input[$key], FFXIVJobEnum::CHOICES)         // abbreviations
                && !in_array($input[$key], FFXIVJobEnum::CHOICES, true)  // full job name
            ) {
                continue;
            }

            if ($key === 'castOrUse'
                && !in_array($input[$key], ['cast', 'use', 'us'])
            ) {
                continue;
            }

            if ($key === 'healOrSpellOrSkill'
                && !in_array($input[$key], ['heal', 'spell', 'skill'])
            ) {
                continue;
            }

            if ($key === 'regenOrShieldOrMit'
                && !in_array($input[$key], [
                    'regen',
                    'shield',
                    'buff',
                    'debuff',
                    'mit',
                    'mitigation',
                    'provoke',
                    'shirk',
                    'cooldown'
                ])
            ) {
                continue;
            }

            if ($key === 'wipeCause'
                && !in_array($input[$key], ['healing', 'enrage', 'tank busters'])
            ) {
                continue;
            }

            // TODO: sanitize job actions maybe but fuck doing that now

            // slight override for grammar's sake
            if ($input[$key] === 'use') {
                $input[$key] = 'us';
            }

            $sanitizedInput[$key] = $input[$key];
        }

        return array_merge(self::REPLACEMENTS, $sanitizedInput);
    }
}
