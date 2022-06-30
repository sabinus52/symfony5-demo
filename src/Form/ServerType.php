<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Form;

use App\Constants\Environment;
use App\Entity\AddressIP;
use App\Entity\OperatingSystem;
use App\Entity\Server;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Olix\BackOfficeBundle\Form\Type\Select2AjaxType;
use Olix\BackOfficeBundle\Form\Type\Select2EntityType;
use Olix\BackOfficeBundle\Form\Type\SwitchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Formulaire d'un serveur.
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ServerType extends AbstractType
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
            ->add('hostname', TextType::class, [
                'label' => 'Nom court',
                'required' => false,
            ])
            ->add('fqdn', TextType::class, [
                'label' => 'Nom long',
                'required' => false,
            ])
            ->add('addrip', Select2AjaxType::class, [
                'label' => 'Sélection IP',
                // 'multiple' => false,
                'required' => false,
                'ajax_route' => 'addressip_ajax',
                'ajax_scroll' => true,
                'class' => AddressIP::class,
                'primary_key' => 'id',
                'label_field' => 'ip',
                'minimum_input_length' => 2,
            ])
            ->add('addressIPs', Select2AjaxType::class, [
                'label' => 'Sélection IPs',
                'multiple' => true,
                'required' => false,
                'ajax_route' => 'addressip_ajax',
                'ajax_scroll' => true,
                'class' => AddressIP::class,
                'primary_key' => 'id',
                'label_field' => 'ip',
                'minimum_input_length' => 3,
            ])
            ->add('virtual', SwitchType::class, [
                'label' => 'Bouton swtich',
                'required' => false,
                'ojs_on_color' => 'indigo',
            ])
            ->add('environment', ChoiceType::class, [
                'label' => 'Environnement',
                'choices' => Environment::getChoices(),
                'choice_value' => 'value',
                'choice_label' => 'label',
            ])
            ->add('operatingSystem', Select2EntityType::class, [
                'label' => 'Système d\'exploitation',
                'required' => false,
                'multiple' => false,
                'class' => OperatingSystem::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('os')
                        ->orderBy('os.name', 'ASC')
                        ->addOrderBy('os.version', 'ASC')
                    ;
                },
                'constraints' => [new NotBlank()],
                'ojs_allow_clear' => true,
            ])
            ->add('state', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => Server::getChoiceStates(),
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Server::class,
        ]);
    }
}
