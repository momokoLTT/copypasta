<?php

declare(strict_types=1);

namespace App\Pasta\Form\Component;

use App\Data\Enum\FFXIVJobNameEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FFXIVJobType extends AbstractType
{
    public const CHECKBOX_SUFFIX = '_useCode';

    public static function addType(FormBuilderInterface $builder, string $key, string $defaultValue): void
    {
        $builder->add(
            $key,
            ChoiceType::class,
            [
                'label' => 'Select a job: ',
                'expanded' => false,
                'choices' => array_flip(FFXIVJobNameEnum::getOptions()),
                'empty_data' => $defaultValue
            ]
        );

        $builder->add(
            $key . self::CHECKBOX_SUFFIX,
            CheckboxType::class,
            [
                'label' => 'Use job code instead'
            ]
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        self::addType($builder,
            $options['key'] ?? 'jobName',
            $options['defaultValue'] ?? ''
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'key' => null,
            'defaultValue' => null,
        ]);
    }
}
