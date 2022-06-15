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
use Doctrine\Persistence\ManagerRegistry;
use Olix\BackOfficeBundle\Form\Type\DatePickerType;
use Olix\BackOfficeBundle\Form\Type\Select2AjaxType;
use Olix\BackOfficeBundle\Form\Type\Select2EntityType;
use Olix\BackOfficeBundle\Form\Type\SwitchType;
use Olix\BackOfficeBundle\Form\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Formulaire de test.
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TestType extends AbstractType
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextType::class, [
                'label' => 'Texte avec ico',
                'required' => false,
                'left_symbol' => '<i class="fas fa-phone"></i>',
                'right_symbol' => 'Km',
                'constraints' => [new Length(['min' => 3]), new NotBlank()],
            ])
            ->add('switch', SwitchType::class, [
                'label' => 'Bouton swtich',
                'help' => 'Voici une aide qui pourrait t\'aider',
                'required' => false,
                'ojs_on_color' => 'indigo',
                'data' => true,
            ])
            ->add('select_users', Select2EntityType::class, [
                'label' => 'Sélection users',
                'required' => false,
                'multiple' => false,
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.username', 'ASC')
                    ;
                },
                'choice_label' => 'username',
                'constraints' => [new NotBlank()],
                'ojs_allow_clear' => true,
            ])
            ->add('ajax_ip', Select2AjaxType::class, [
                'label' => 'Sélection IP',
                // 'multiple' => false,
                'required' => false,
                'ajax_route' => 'addressip_ajax',
                'ajax_scroll' => false,
                'class' => AddressIP::class,
                'primary_key' => 'id',
                'label_field' => 'ip',
                'minimum_input_length' => 2,
                // 'constraints' => [new NotBlank()],
            ])
            ->add('ajax_ips', Select2AjaxType::class, [
                'label' => 'Sélection IPs',
                'multiple' => true,
                'required' => false,
                'ajax_route' => 'addressip_ajax',
                'ajax_scroll' => true,
                'class' => AddressIP::class,
                'primary_key' => 'id',
                'label_field' => 'ip',
                'minimum_input_length' => 3,
                // 'constraints' => [new NotBlank()],
            ])
            ->add('date', DatePickerType::class, [
                'label' => 'Date',
                // 'ojs_min_date' => new \DateTime('05/05/2022'),
                'ojs_calendar_weeks' => true,
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
