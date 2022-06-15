<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Form;

use DateTime;
use Olix\BackOfficeBundle\Form\Type\DatePickerType;
use Olix\BackOfficeBundle\Form\Type\DateTimePickerType;
use Olix\BackOfficeBundle\Form\Type\TimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire des widgets de type "DateTimePicker".
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class TestDateTimePickerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datetime', DateTimePickerType::class, [
                'label' => 'Date et heure',
                // 'ojs_min_date' => new DateTime('05/05/2022'),
                'ojs_default_date' => new DateTime('2022-05-10'),
                'ojs_disabled_dates' => [new DateTime('2022-05-13'), new DateTime('2022-05-15')],
                // 'ojs_side_by_side' => true,
                'ojs_days_of_week_disabled' => [0, 6],
            ])
            ->add('date', DatePickerType::class, [
                'label' => 'Date',
                // 'ojs_min_date' => new DateTime('05/05/2022'),
                'ojs_calendar_weeks' => true,
            ])
            ->add('time', TimePickerType::class, [
                'label' => 'Heure',
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
