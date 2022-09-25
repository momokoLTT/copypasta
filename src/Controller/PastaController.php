<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\YouKnowWhatData;
use App\Generator\PastaGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/pasta")
 */
class PastaController extends AbstractController
{
    public function __construct(private PastaGenerator $generator) {
    }

    /**
     * @Route(path="/you-know-what")
     */
    public function youKnowWhat(Request $request): JsonResponse
    {
        return new JsonResponse($this->generator->generatePasta('you-know-what-nia', $request));
    }

    /**
     * @Route(path="/test")
     */
    public function test(): Response
    {
        return new Response(YouKnowWhatData::createPasta([
            'goodHealerName' => 'PSI',
            'goodHealerAbility1' => 'feint',

            'badHealerName' => 'neku',
            'badHealerJob' => 'ninja',
            'badHealerAbility1' => 'mudra',

            'jobType' => 'DPS',
            'castOrUse' => 'use',
            'healOrSpellOrSkill' => 'skill',
            'regenOrShieldOrMit' => 'buff',
            'wipeCause' => 'enrage',
        ]));
    }
}
