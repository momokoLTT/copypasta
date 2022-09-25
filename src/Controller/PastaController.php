<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\PastaService;
use App\Data\YouKnowWhatData;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/pasta")
 */
class PastaController extends AbstractController
{
    public function __construct(private PastaService $service)
    {
    }

    /**
     * @Route(path="/you-know-what")
     *
     * @throws JsonException
     */
    public function youKnowWhat(Request $request): Response
    {
        $input = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return new Response($this->service->createPasta(YouKnowWhatData::KEY, $input));
    }

    /**
     * @Route(path="/test")
     */
    public function test(): Response
    {
        return new Response($this->service->createPasta(YouKnowWhatData::KEY, [
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
