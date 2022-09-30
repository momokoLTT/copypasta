<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\Collection\PastaCollection;
use App\Service\PastaService;
use App\Data\YouKnowWhatData;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PastaController extends AbstractController
{
    public function __construct(private PastaService $service)
    {
    }

    #[Route(path: '/pasta/submit', methods: ['POST'])]
    public function submit(Request $request): Response
    {
        try {
            $input = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return new Response('An error occurred while attempting to parse your input');
        }

        return new Response($this->service->createPasta($input['chosenPasta'], $input['options']));
    }

    #[Route(path: '/pasta/test', methods: ['GET', 'POST'])]
    public function test(): Response
    {
        return new Response($this->service->createPasta(YouKnowWhatData::getName(), [
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
