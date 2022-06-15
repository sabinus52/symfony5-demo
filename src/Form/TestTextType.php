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
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire des widgets de type "Text".
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class TestTextType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'help' => 'Voici une aide qui pourrait t\'aider',
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Texte',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('integer', IntegerType::class, [
                'label' => 'Entier',
            ])
            ->add('money', MoneyType::class, [
                'label' => 'Somme',
            ])
            ->add('number', NumberType::class, [
                'label' => 'Nombre',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
            ])
            ->add('percent', PercentType::class, [
                'label' => 'Pourcentage',
            ])
            ->add('search', SearchType::class, [
                'label' => 'Recherche',
            ])
            ->add('url', UrlType::class, [
                'label' => 'URL',
            ])
            ->add('range', RangeType::class, [ // TODO voir pour les valeurs à afficher
                'label' => 'Ecart',
                'attr' => [
                    'min' => 5,
                    'max' => 10,
                ],
            ])
            ->add('tel', TelType::class, [  // TODO Voir pour y mettre un masque
                'label' => 'Téléphone',
            ])
            ->add('color', ColorType::class, [  // TODO Voir pour y mettre un masque
                'label' => 'Couleur',
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
