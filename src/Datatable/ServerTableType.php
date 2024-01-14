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
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\Column\TwigStringColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;

/**
 * Datatables de la liste des serveurs.
 *
 * @author Sabinus52 <sabinus52@gmail.com>
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class ServerTableType implements DataTableTypeInterface
{
    /**
     * Undocumented function.
     *
     * @param DataTable    $dataTable
     * @param array<mixed> $options
     */
    public function configure(DataTable $dataTable, array $options): void
    {
        $dataTable
            ->add('id', TextColumn::class, [
                'label' => 'Id',
            ])
            ->add('hostname', TextColumn::class, [
                'label' => 'Hostname',
                'searchable' => true,
            ])
            ->add('addrip', TextColumn::class, [
                'label' => 'Adresse IP',
                'field' => 'addrip.ip',
                'searchable' => true,
            ])
            ->add('virtual', BoolColumn::class, [
                'label' => 'Virtuel',
                'trueValue' => 'yes',
                'falseValue' => 'no',
                'nullValue' => '',
            ])
            ->add('environment', TwigStringColumn::class, [
                'label' => 'Environnement',
                'searchable' => true,
                'template' => '{{ row.environment.badge|raw }}',
            ])
            ->add('os', TextColumn::class, [
                'label' => 'OS',
                'field' => 'operatingSystem.name',
                'searchable' => true,
                'render' => static fn ($value, $context) => sprintf('%s (%s) %s %s', $value, $context->getOperatingSystem()->getBits(), $context->getOperatingSystem()->getVersion(), $context->getOperatingSystem()->getAdditional()),
            ])
            ->add('state', TextColumn::class, [
                'label' => 'Statut',
                'raw' => true,
                'data' => static fn ($row) => sprintf('<b>%s</b>', $row->getStateLabel()),
            ])
            ->add('deletedAt', DateTimeColumn::class, [
                'label' => 'Supprimé',
                'format' => 'd/m/Y',
            ])
            ->add('buttons', TwigColumn::class, [
                'label' => '',
                'className' => 'text-right align-middle',
                'template' => 'tables/server-buttonbar.html.twig',
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Server::class,
            ])
        ;
    }
}
