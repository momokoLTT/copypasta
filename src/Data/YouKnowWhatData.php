<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\Collection\EnumCollection;
use App\Data\Enum\FFXIVJobCodeEnum;
use App\Data\Enum\FFXIVJobNameEnum;
use RuntimeException;

class YouKnowWhatData implements PastaDataInterface
{
    public function __construct(private EnumCollection $enums)
    {
    }

    public static function getName(): string
    {
        return 'you-know-what-nia';
    }

    public function getPrettyName(): string
    {
        return "You know what? Nia can have the weapon.";
    }

    public function getBaseText(): string
    {
        return <<< PASTA
You know what? You know what I want? I want the person who carried the past fucking 500 pulls to have the weapon so you know what? :strGoodHealerName: can have the fucking weapon. :strGoodHealerName: can have the goddamn fucking weapon. You know who else can have the mount too? :strGoodHealerName: can have the mount too. And you know who can have the minion? :strGoodHealerName: can have the fucking minion too. And you know who can have the fucking orchestrion roll? :strGoodHealerName: can have the orchestrion roll too. End of story, have a goodnight everyone, goodbye.
:strBadHealerName: you are the greediest piece of shit ;choiceJobType; I have ever played with in my entire fucking life. You can not ;choiceCastOrUse; a :strBadHealerAbility1: for the fucking life of you, Jesus fucking Christ think of the fucking raid and stop parsing zero on healing. You absolute fucking selfish asshole dumb-fuck, you say "I don't care about parsing, I don't have the weapon anyway" then what the fuck are you doing? :choiceCastOrUse: a fucking ;choiceHealOrSpellOrSkill;, Jesus Christ you're so fucking selfish and stupid. Look at :strGoodHealerName:, ;choiceCastOrUse;ing 50 fucking :strGoodHealerAbility1:s or whatever, just to keep the people with the DOTs alive because you can't give them a fucking ;choiceRegenOrShieldOrMit;, or you can't ;choiceCastOrUse; a fucking :strBadHealerAbility1:, holy shit are you that fucking stupid? And your damage doesn't even fucking make up for it, your damage is fucking shit for how much you fucking grief the entire party. Holy shit, I made a fucking video compilation of all the times that we died to ;choiceWipeCause;, you can say "oh we died to mechanics more than we died to ;choiceWipeCause;!" But we shouldn't have died to ;choiceWipeCause;, a single goddamn fucking time. If you just healed the fucking party instead of being a fucking, idiot, fucking asshole holy shit. You are so fucking stupid, oh my god. How hard is it to fucking ;choiceCastOrUse; a :strBadHealerAbility1: you fucking dumbass, holy shit. Do you just not want to clear? You told me "I don't want to spend any excessive time in reclears this week because that would be dumb. That's why I don't want to try the uptime strats." Then why don't you ;choiceCastOrUse; a fucking ;choiceHealOrSpellOrSkill; instead of being fucking stupid. Yeah leave voice chat you fucking pussy, Jesus Christ this static is done. Goodnight everyone. Congratulations to everyone that got loot, thank you for coming. I love all of you except :strBadHealerName:, :strBadHealerName: can go fuck themselves and die.
Shut the fuck up. I'm talking. I'm talking. You let them walk all over you and that just gives rubs me the wrong way. I can't believe you let your friend do you to you like that. I genuinely feel bad for you and hope you find something better. And I hope :strBadHealerName: goes and fucks themselves in a new group. And I hope that you world prog cause you're one of the best damn healers I've ever fucking played with in my entire life. You're so fucking good. You rarely made mistakes and you healed so much. Holy shit, you are so good. Please find a static that is as good as you. Holy shit, cause you're not gonna find it here cause you're better than me. And I played like shit this tier, and even if played at my absolute best like I played in DSR you woulda been 10 times better than me, you are so good. So find a good static, please. not with them. Not with that greedy ass ;xivJobBadHealerJob;. Jesus Christ. Ok, good night everyone. I'm done. This group is done. Find a new group for reclears. Thank you everyone for coming.
PASTA;
    }

    public function getDefaultValues(): array
    {
        return [
            'strGoodHealerName' => 'Nia',
            'strGoodHealerAbility1' => 'adloquium',

            'strBadHealerName' => 'Katalena',
            'xivJobBadHealerJob' => 'white mage',
            'strBadHealerAbility1' => 'Medica II',

            'choiceJobType' => 'healer',
            'choiceCastOrUse' => 'cast',
            'choiceHealOrSpellOrSkill' => 'heal',
            'choiceRegenOrShieldOrMit' => 'regen',
            'choiceWipeCause' => 'healing',
        ];
    }

    /**
     * @param array<string,string> $input
     *
     * @return array<string,string>
     */
    public function sanitizeInput(array $input): array
    {
        $jobCodes = $this->enums->get(FFXIVJobCodeEnum::getName());
        $jobNames = $this->enums->get(FFXIVJobNameEnum::getName());
        if (!$jobCodes || !$jobNames) {
            throw new RuntimeException('Unable to get job data for ' . $this::getName());
        }

        $sanitizedInput = [];
        foreach ($this->getDefaultValues() as $key => $defaultValue) {
            $value = $input[$key];
            if (!$value) {
                continue;
            }

            if ($key === 'xivJobBadHealerJob'
                && !$jobNames->isAllowed($value)
                && !$jobCodes->isAllowed($value)
            ) {
                continue;
            }

            // response gives the answer # so turn that into a string
            if (str_starts_with($key, 'choice')) {
                $value = $this->getChoicesFor($key)[$value];
            }

            // slight override for grammar's sake
            if ($key === 'choiceCastOrUse' && $value === 'use') {
                $value = 'us';
            }

            $sanitizedInput[$key] = $value;
        }

        return $sanitizedInput;
    }

    public function getChoicesFor(string $key): ?array
    {
        $choices = [
            'choiceJobType' => ['healer', 'tank', 'dps'],
            'choiceCastOrUse' => ['cast', 'use', 'us'],
            'choiceHealOrSpellOrSkill' => ['heal', 'spell', 'skill'],
            'choiceRegenOrShieldOrMit' => [
                'regen',
                'shield',
                'buff',
                'debuff',
                'mit',
                'mitigation',
                'provoke',
                'shirk',
                'cooldown'
            ],
            'choiceWipeCause' => ['healing', 'enrage', 'tank busters'],
        ];

        return $choices[$key] ?? null;
    }
}
