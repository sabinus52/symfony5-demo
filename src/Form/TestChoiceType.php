<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire des widgets de type "Choice".
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class TestChoiceType extends AbstractType
{
    /**
     * @var array<int>
     */
    protected static $choices = [
        'Choix 1' => 1,
        'Choix 2' => 2,
        'Choix 3' => 3,
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('select_simple', ChoiceType::class, [
                'label' => 'Sélection',
                'expanded' => false,
                'multiple' => false,
                'choices' => self::$choices,
                'help' => 'Voici une aide qui pourrait t\'aider',
            ])
            ->add('select_multiple', ChoiceType::class, [
                'label' => 'Sélection multiple',
                'expanded' => false,
                'multiple' => true,
                'choices' => self::$choices,
            ])
            ->add('radiobox', ChoiceType::class, [
                'label' => 'Sélection par checkbox',
                'expanded' => true,
                'multiple' => false,
                'choices' => self::$choices,
                'help' => 'Voici une aide qui pourrait t\'aider',
            ])
            ->add('checkbox', ChoiceType::class, [
                'label' => 'Sélection par radiobox',
                'expanded' => true,
                'multiple' => true,
                'choices' => self::$choices,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
