<?php

declare(strict_types=1);

namespace App\Pasta\Form\Component;

use App\Data\Enum\FFXIVJobEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class FFXIVJobType extends AbstractType
{
    public const CHECKBOX_SUFFIX = '_useShortValue';

    public static function addType(FormBuilderInterface $builder, string $key, string $defaultValue): void
    {
        $builder->add(
            $key,
            ChoiceType::class,
            [
                'expanded' => true,
                'choices' => FFXIVJobEnum::CHOICES,
                'empty_data' => $defaultValue
            ]
        );

        $builder->add($key . self::CHECKBOX_SUFFIX, CheckboxType::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        self::addType($builder, 'jobName', $options['defaultValue']);
    }
}
