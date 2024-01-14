<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Datatable;

use App\Constants\Environment;
use App\Entity\Server;
use Olix\BackOfficeBundle\Datatable\AbstractDatatable;
use Olix\BackOfficeBundle\Datatable\Column\ActionColumn;
use Olix\BackOfficeBundle\Datatable\Column\BooleanColumn;
use Olix\BackOfficeBundle\Datatable\Column\Column;
use Olix\BackOfficeBundle\Datatable\Column\DateTimeColumn;
use Olix\BackOfficeBundle\Datatable\Column\VirtualColumn;
use Olix\BackOfficeBundle\Datatable\Filter\SelectFilter;

/**
 * Classe ServerDatable.
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ServerDatatable extends AbstractDatatable
{
    public function getLineFormatter()
    {
        return static function ($row) {
            // $row['os'] = 'x';
            if (isset($row['operatingSystem']['name'])) {
                $row['os'] = $row['operatingSystem']['name'].' ('.$row['operatingSystem']['bits'].') '.$row['operatingSystem']['version'].' '.$row['operatingSystem']['additional'];
            }
            $row['environment'] = $row['environment']->getBadge();

            return $row;
        };
    }

    /**
     * {@inheritdoc}
     *
     * @param array<mixed> $options
     */
    public function buildDatatable(array $options = []): void
    {
        $this->ajax->set([]);

        $this->options->set([
            'individual_filtering' => true,
            'order' => [[0, 'asc']],
        ]);

        $this->columnBuilder
            ->add('id', Column::class, [
                'title' => 'Id',
            ])
            ->add('hostname', Column::class, [
                'title' => 'Hostname',
                'searchable' => true,
            ])
            ->add('addrip.ip', Column::class, [
                'title' => 'Adresse IP',
                'default_content' => '',
                'searchable' => true,
            ])
            ->add('virtual', BooleanColumn::class, [
                'title' => 'Virtuel',
            ])
            ->add('environment', Column::class, [
                'title' => 'Environnement',
                'searchable' => true,
                'filter' => [SelectFilter::class, [
                    'multiple' => false,
                    'cancel_button' => false,
                    'select_options' => array_merge(['' => 'Tous'], Environment::getFilters()),
                ]],
            ])
            ->add('os', VirtualColumn::class, [
                'title' => 'OS',
                'default_content' => '',
                'order_column' => 'operatingSystem.bits',
            ])
            ->add('operatingSystem.name', Column::class, [
                'visible' => false,
                'default_content' => '',
            ])
            ->add('operatingSystem.bits', Column::class, [
                'visible' => false,
                'default_content' => '',
            ])
            ->add('operatingSystem.version', Column::class, [
                'visible' => false,
                'default_content' => '',
            ])
            ->add('operatingSystem.additional', Column::class, [
                'visible' => false,
                'default_content' => '',
            ])
            ->add('state', Column::class, [
                'title' => 'Statut',
            ])
            ->add('deletedAt', DateTimeColumn::class, [
                'title' => 'Supprimé',
                'date_format' => 'L',
            ])
            ->add(null, ActionColumn::class, [
                'actions' => [
                    [
                        'route' => 'table_server_edit',
                        'icon' => 'fas fa-edit',
                        'label' => 'Edit',
                        'route_parameters' => [
                            'id' => 'id',
                        ],
                        'attributes' => [
                            'rel' => 'tooltip',
                            'title' => 'Edit',
                            'class' => 'btn btn-primary btn-sm',
                            'role' => 'button',
                        ],
                    ],
                    [
                        'route' => 'table_server_delete',
                        'icon' => 'fas fa-trash',
                        'label' => 'Delete',
                        'route_parameters' => [
                            'id' => 'id',
                        ],
                        'attributes' => [
                            'rel' => 'tooltip',
                            'title' => 'Delete',
                            'class' => 'btn btn-danger btn-sm',
                            'role' => 'button',
                            'onclick' => 'return olixBackOffice.confirmDelete(this)',
                        ],
                    ],
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity(): string
    {
        return Server::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'server_datatable';
    }
}
