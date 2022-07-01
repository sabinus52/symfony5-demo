<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Datatable;

use App\Entity\AddressIP;
use Olix\BackOfficeBundle\Datatable\AbstractDatatable;
use Olix\BackOfficeBundle\Datatable\Column\ActionColumn;
use Olix\BackOfficeBundle\Datatable\Column\Column;

/**
 * Classe AddressIPDatable.
 */
class AddressIPDatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     *
     * @param array<mixed> $options
     */
    public function buildDatatable(array $options = []): void
    {
        $this->ajax->set([]);

        $this->options->set([]);

        $this->columnBuilder
            ->add('id', Column::class, [
                'title' => 'Id',
            ])
            ->add('ip', Column::class, [
                'title' => 'IP',
                'searchable' => true,
            ])
            ->add(null, ActionColumn::class, [
                'actions' => [
                    [
                        'route' => 'table_adrip__edit',
                        'icon' => 'fas fa-edit',
                        'label' => 'Edit',
                        'route_parameters' => [
                            'id' => 'id',
                        ],
                        'attributes' => [
                            'title' => 'Edit',
                            'class' => 'btn btn-primary btn-sm',
                            'role' => 'button',
                        ],
                    ],
                    [
                        'route' => 'table_adrip__delete',
                        'icon' => 'fas fa-trash',
                        'label' => 'Delete',
                        'route_parameters' => [
                            'id' => 'id',
                        ],
                        'attributes' => [
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
    public function getEntity()
    {
        return AddressIP::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'addressip_datatable';
    }
}
