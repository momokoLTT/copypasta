<?php

declare(strict_types=1);

namespace App\Extension;

use Symfony\Component\Form\FormView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LoopOverFormExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getFormElements', [$this, 'getFormElements'])
        ];
    }

    public function getFormElements(FormView $form): array
    {
        $formData = [];
        foreach ($form->children as $element) {
            $key = $element->vars['name'];
            if ($key === 'submit') {
                continue;
            }

            // TODO: map to actual pretty string
            $formData[$key]['prettyName'] = $key;
            $formData[$key]['element'] = $element;
        }

        return $formData;
    }
}