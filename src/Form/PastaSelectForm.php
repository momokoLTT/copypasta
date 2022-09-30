<?php

declare(strict_types=1);

namespace App\Pasta\Form;

use RuntimeException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PastaSelectForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $pastaCollection = $options['pastaCollection'];
        if (!$pastaCollection) {
            throw new RuntimeException('Not all required parameters given for form');
        }

        $builder->add(
            'pastaName',
            ChoiceType::class,
            [
                'choices' => $pastaCollection->getNames(),
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'pastaCollection' => null
        ]);
    }
}
