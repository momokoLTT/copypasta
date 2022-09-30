<?php

declare(strict_types=1);

namespace App\Pasta\Form;

use App\Data\Collection\EnumCollection;
use App\Data\Collection\PastaCollection;
use App\Pasta\Form\Component\FFXIVJobType;
use RuntimeException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DynamicPastaForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var PastaCollection $pastaCollection */
        $pastaCollection = $options['pastaCollection'];

        /** @var EnumCollection $enumCollection */
        $enumCollection = $options['enumCollection'];

        /** @var string $chosenPasta */
        $chosenPasta = $options['chosenPasta'];

        if (!$pastaCollection || !$enumCollection || $chosenPasta === '') {
            throw new RuntimeException('Not all required parameters given for form');
        }

        $data = $pastaCollection->get($options['pasta']);
        if (!$data) {
            return;
        }

        foreach ($data->getDefaultValues() as $key => $defaultValue) {
            switch (true) {
                case str_starts_with($key, 'str'):
                    $this->addText($builder, $key, $defaultValue);
                    break;
                case str_starts_with($key, 'bool'):
                    $this->addCheckbox($builder, $key, $defaultValue);
                    break;
                case str_starts_with($key, 'enum'):
                    $enum = $enumCollection->get($key);
                    if (!$enum) {
                        throw new RuntimeException("no data found for enum field $key");
                    }

                    $this->addDropdown($builder, $key, $defaultValue, $enum::getOptions());
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

    private function addDropdown(FormBuilderInterface $builder, string $key, string $defaultValue, array $options): void
    {
        $builder->add($key, ChoiceType::class,
            [
                'empty_data' => $defaultValue,
                'choices' => $options,
            ]
        );
    }

    private function addXivJobChoice(FormBuilderInterface $builder, string $key, ?string $defaultValue): void
    {
        $builder->add($key, FFXIVJobType::class, ['defaultValue' => $defaultValue ?? '']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'pastaCollection' => null,
            'enumCollection' => null,
            'chosenPasta' => '',
        ]);
    }
}
