<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\AddressIP;
use App\Form\AddressIPType;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur des tables.
 *
 * @author Sabinus52 <sabinus52@gmail.com>
 */
class TablesAddressIPController extends AbstractController
{
    /**
     * @Route("/tables/addressip/list", name="table_adrip__list")
     */
    public function index(Request $request, DataTableFactory $factory): Response
    {
        $datatable = $factory->create()
            ->add('id', TextColumn::class, [
                'label' => 'Id',
            ])
            ->add('ip', TextColumn::class, [
                'label' => 'IP',
                'searchable' => true,
            ])
            ->add('buttons', TwigColumn::class, [
                'label' => '',
                'className' => 'text-right align-middle',
                'template' => 'tables/addressip-buttonbar.html.twig',
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => AddressIP::class,
            ])
            ->handleRequest($request)
        ;

        if ($datatable->isCallback()) {
            return $datatable->getResponse();
        }

        return $this->renderForm('tables/addressip-index.html.twig', [
            'datatable' => $datatable,
        ]);
    }

    /**
     * @Route("/tables/addressip/create", name="table_adrip__create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adrip = new AddressIP();
        $form = $this->createForm(AddressIPType::class, $adrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adrip);
            $entityManager->flush();
            $this->addFlash('success', sprintf('La création du menu <strong>%s</strong> a bien été prise en compte', $adrip));

            return new Response('OK');
        }

        return $this->renderForm('tables/addressip-edit.html.twig', [
            'form' => $form,
            'title' => 'Créer une nouvelle adresse IP',
        ]);
    }

    /**
     * Update server.
     *
     * @Route("/tables/addressip/edit/{id}", name="table_adrip__edit")
     */
    public function update(Request $request, AddressIP $adrip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AddressIPType::class, $adrip);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', sprintf('La modification de l\'adresse IP <strong>%s</strong> a bien été prise en compte', $adrip));

            return new Response('OK');
        }

        return $this->renderForm('tables/addressip-edit.html.twig', [
            'form' => $form,
            'title' => 'Modifier une adresse IP',
        ]);
    }

    /**
     * @Route("/tables/addressip/delete/{id}", name="table_adrip__delete")
     */
    public function remove(Request $request, AddressIP $adrip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($adrip);
            $entityManager->flush();
            $this->addFlash('success', sprintf('La suppression de l\'adresse IP <strong>%s</strong> a bien été prise en compte', $adrip));

            return new Response('OK');
        }

        return $this->renderForm('@OlixBackOffice/Include/modal-content-delete.html.twig', [
            'form' => $form,
            'element' => sprintf('l\'adresse IP : <strong>%s</strong>', $adrip),
        ]);
    }
}
