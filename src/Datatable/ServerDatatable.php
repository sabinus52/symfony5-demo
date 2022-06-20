<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Datatable;

use App\Entity\Server;
use App\Entity\User;
use Olix\BackOfficeBundle\Datatable\AbstractDatatable;
use Olix\BackOfficeBundle\Datatable\Column\ActionColumn;
use Olix\BackOfficeBundle\Datatable\Column\BooleanColumn;
use Olix\BackOfficeBundle\Datatable\Column\Column;
use Olix\BackOfficeBundle\Datatable\Column\DateTimeColumn;
use Olix\BackOfficeBundle\Datatable\Column\VirtualColumn;
use Olix\BackOfficeBundle\Datatable\Filter\SelectFilter;

/**
 * Classe ServerDatable.
 */
class ServerDatatable extends AbstractDatatable
{
    public function getLineFormatter()
    {
        $envs = Server::getEnvironments();
        $formatter = function ($row) use ($envs) {
            // $row['os'] = 'x';
            if (isset($row['operatingSystem']['name'])) {
                $row['os'] = $row['operatingSystem']['name'].' ('.$row['operatingSystem']['bits'].') '.$row['operatingSystem']['version'].' '.$row['operatingSystem']['additional'];
            }
            $row['environment'] = '<span class="badge badge-'.$envs[$row['environment']]['color'].'">'.$envs[$row['environment']]['label'].'</span>';

            return $row;
        };

        return $formatter;
    }

    /**
     * {@inheritdoc}
     *
     * @param array<mixed> $options
     */
    public function buildDatatable(array $options = []): void
    {
        $this->ajax->set([
            // send some extra example data
            'data' => ['data1' => 1, 'data2' => 2],
            // cache for 10 pages
            'pipeline' => 10,
        ]);

        $this->options->set([
            'individual_filtering' => true,
            'order' => [[0, 'asc']],
        ]);

        // $users = $this->em->getRepository(User::class)->findAll();

        $this->columnBuilder
            ->add('id', Column::class, [
                'title' => 'Id',
                'searchable' => false,
                'orderable' => true,
            ])
            ->add('hostname', Column::class, [
                'title' => 'Hostname',
            ])
            ->add('addrip.ip', Column::class, [
                'title' => 'Adresse IP',
                'default_content' => '',
                // 'data' => 'addrip[,].ip',
            ])
            ->add('virtual', BooleanColumn::class, [
                'title' => 'Virtuel',
            ])
            ->add('environment', Column::class, [
                'title' => 'Environnement',
                'filter' => [SelectFilter::class, [
                    'multiple' => false,
                    'cancel_button' => false,
                    'select_options' => array_merge(['' => 'Tous'], Server::getEnvironments('label')),
                ]],
            ])
            ->add('os', VirtualColumn::class, [
                'default_content' => '',
                'title' => 'OS',
                // 'default_content' => 'ZZ',
                'searchable' => false,
                'orderable' => true,
                'order_column' => 'operatingSystem.bits', // use the 'createdBy.username' column for ordering
                // 'search_column' => 'createdBy.username', // use the 'createdBy.username' column for searching
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
                'searchable' => false,
            ])
            ->add(null, ActionColumn::class, [
                'title' => 'Actions',
                'start_html' => '<div class="start_actions">',
                'end_html' => '</div>',
                'actions' => [
                    [
                        'route' => 'table_server_edit',
                        'label' => 'Show Posting',
                        'route_parameters' => [
                            'id' => 'id',
                            '_format' => 'html',
                            '_locale' => 'en',
                        ],
                        /*'render_if' => function($row) {
                            return $row['createdBy']['username'] === 'user' && $this->authorizationChecker->isGranted('ROLE_USER');
                        },*/
                        'attributes' => [
                            'rel' => 'tooltip',
                            'title' => 'Show',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
                        ],
                        'start_html' => '<div class="start_show_action">',
                        'end_html' => '</div>',
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
