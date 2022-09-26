<?php

declare(strict_types=1);

namespace App\Pasta\Form;

use App\Data\YouKnowWhatData;
use App\Pasta\Form\Component\FFXIVJobType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class YouKnowWhatForm extends AbstractType
{
    // TODO: dynamically fill this instead of hardcoding it
    private const CLASSES = [
        YouKnowWhatData::KEY => YouKnowWhatData::class,
    ];

    private const ENUMS = [
        YouKnowWhatData::KEY => [
            YouKnowWhatEnums::KEY => YouKnowWhatEnums::class,
        ]
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = self::CLASSES[$options['pasta']];
        foreach ($data::REPLACEMENTS as $key => $defaultValue) {
            switch (true) {
                case str_starts_with($key, 'str'):
                    $this->addText($builder, $key, $defaultValue);
                    break;
                case str_starts_with($key, 'bool'):
                    $this->addCheckbox($builder, $key, $defaultValue);
                    break;
                case str_starts_with($key, 'enum'):
                    $this->addDropdown($builder, $key, $defaultValue, self::ENUMS[$options['pasta'][$key]]::CHOICES);
                    break;
                case str_starts_with($key, 'xivJob'):
                    $this->addXivJobChoice($builder, $key, $defaultValue);
                    break;
                default:
                    // do nothing
                    break;
            }
        }
    }

    private function addText(FormBuilderInterface $builder, string $key, ?string $defaultValue): void
    {
        $builder->add($key, TextType::class, ['empty_data' => $defaultValue ?? '']);
    }

    private function addCheckBox(FormBuilderInterface $builder, string $key, bool $defaultValue): void
    {
        $builder->add($key, CheckboxType::class, ['empty_data' => $defaultValue ?? false]);
    }

    private function addDropdown(FormBuilderInterface $builder, string $key, string $defaultValue, array $choices): void
    {
        $builder->add($key, ChoiceType::class, [
            [
                'empty_data' => $defaultValue,
                'choices' => $choices,
            ]
        ]);
    }

    private function addXivJobChoice(FormBuilderInterface $builder, string $key, ?string $defaultValue): void
    {
        $builder->add($key, FFXIVJobType::class, ['defaultValue' => $defaultValue ?? '']);
    }
}
