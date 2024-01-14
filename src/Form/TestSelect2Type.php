<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\AddressIP;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Olix\BackOfficeBundle\Form\Type\DualListBoxChoiceType;
use Olix\BackOfficeBundle\Form\Type\Select2AjaxType;
use Olix\BackOfficeBundle\Form\Type\Select2ChoiceType;
use Olix\BackOfficeBundle\Form\Type\Select2EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire des widgets de type "Select2".
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class TestSelect2Type extends AbstractType
{
    /**
     * @var array<int>
     */
    protected static $choices = [
        'Choix 1' => 1,
        'Choix 2' => 2,
        'Choix 3' => 3,
        'Choix 4' => 4,
        'Choix 5' => 5,
        'Choix 6' => 6,
        'Choix 7' => 7,
        'Choix 8' => 8,
        'Choix 9' => 9,
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('select_simple', Select2ChoiceType::class, [
                'label' => 'Sélection',
                'multiple' => false,
                'choices' => self::$choices,
                'help' => 'Voici une aide qui pourrait t\'aider',
                'color' => 'danger',
                'js_minimum_input_length' => 2,
            ])
            ->add('select_multiple', Select2ChoiceType::class, [
                'label' => 'Sélection multiple',
                'multiple' => true,
                'choices' => self::$choices,
                'color' => 'indigo',
                'js_placeholder' => 'Mon choix',
            ])
            ->add('select_users', Select2EntityType::class, [
                'label' => 'Sélection users',
                'multiple' => false,
                'class' => User::class,
                'query_builder' => static fn (EntityRepository $er) => $er->createQueryBuilder('u')
                    ->orderBy('u.username', 'ASC'),
                'choice_label' => 'username',
            ])
            ->add('ajax_repo', Select2AjaxType::class, [
                'label' => 'Sélection Ajax',
                'multiple' => false,
                'required' => false,
                'remote_route' => 'form_test_select2_ajax',
                'ajax_js_scroll' => false,
                'class' => AddressIP::class,
                'class_property' => 'ip',
                'class_pkey' => 'id',
                'class_label' => 'ip',
                'js_minimum_input_length' => 3,
            ])
            /*->add('ajax_ips', Select2ChoiceType::class, [
                'label' => 'Sélection IPs',
                'multiple' => false,
                'remote_route' => 'addressip_ajax',
                'ajax_scroll' => false,
                'js_minimum_input_length' => 2,
                'js_allow_clear' => true,
            ])*/
            ->add('duallist', DualListBoxChoiceType::class, [
                'label' => 'DualBox multiple',
                'multiple' => true,
                'choices' => self::$choices,
                'help' => 'Voici une aide qui pourrait t\'aider',
                'js_filter_place_holder' => 'Texte à filtrer',
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
