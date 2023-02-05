<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Form;

use Olix\BackOfficeBundle\Form\Type\SwitchType;
use Olix\BackOfficeBundle\Form\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire des widgets de type "Other".
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class TestOtherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('check', CheckboxType::class, [
                'label' => 'Checkbox',
                'attr' => [
                ],
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'help' => 'Voici une aide qui pourrait t\'aider',
            ])
            ->add('radio', RadioType::class, [
                'label' => 'Radio',
            ])
            ->add('file', FileType::class, [
                'label' => 'Fichier',
            ])
            ->add('switch', SwitchType::class, [
                'label' => 'Bouton swtich',
                'help' => 'Voici une aide qui pourrait t\'aider',
                'js_size' => 'mini',
                'js_on_color' => 'indigo',
                'data' => true,
            ])
            ->add('text', TextType::class, [
                'label' => 'Texte avec ico',
                'left_symbol' => '<i class="fas fa-phone"></i>',
                'right_symbol' => 'Km',
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
