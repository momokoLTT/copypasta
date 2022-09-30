<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\Collection\EnumCollection;
use App\Data\Collection\PastaCollection;
use App\Pasta\Form\DynamicPastaForm;
use App\Pasta\Form\PastaSelectForm;
use App\Service\PastaService;
use App\Data\YouKnowWhatData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PastaController extends AbstractController
{
    public function __construct(
        private PastaService $pastaService,
        private PastaCollection $pastaCollection,
        private EnumCollection $enumCollection,
    ) {
    }

    #[Route(path: '/pasta', methods: ['GET', 'POST'])]
    public function entryPoint(): Response
    {
        return $this->redirect('/pasta/select');
    }

    #[Route(path: '/pasta/test', methods: ['GET', 'POST'])]
    public function test(): Response
    {
        return new Response($this->pastaService->createPasta(YouKnowWhatData::getName(), [
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

    #[Route(path: '/pasta/select', methods: ['GET', 'POST'])]
    public function pastaSelect(Request $request): Response
    {
        $form = $this->createForm(PastaSelectForm::class, null, ['pastaCollection' => $this->pastaCollection]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect('/pasta/' . $form->getData()['pastaName']);
        }

        return $this->renderForm('select.html.twig', ['form' => $form]);
    }

    #[Route(path: '/pasta/{pastaName}', methods: ['GET', 'POST'])]
    public function submit(Request $request): Response
    {
        $form = $this->createForm(DynamicPastaForm::class, null, [
            'pastaCollection' => $this->pastaCollection,
            'enumCollection' => $this->enumCollection,
            'chosenPasta' => $request->get('pastaName'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $input = $form->getData();

            return new Response($this->pastaService->createPasta($request->get('pastaName'), $input));
        }

        return $this->renderForm('pasta.html.twig', [
            'form' => $form
        ]);
    }
}
