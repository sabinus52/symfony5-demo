<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Controller;

use App\Datatable\ServerDatatable;
use App\Entity\Server;
use App\Form\ServerType;
use Doctrine\ORM\EntityManagerInterface;
use Olix\BackOfficeBundle\Datatable\Response\DatatableResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur des tables.
 */
class TablesController extends AbstractController
{
    /**
     * Lists all Server entities.
     *
     * @Route("/tables/server/list", name="table_server_list")
     */
    public function listServer(Request $request, ServerDatatable $datatable, DatatableResponse $responseService): Response
    {
        $isAjax = $request->isXmlHttpRequest();

        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService->setDatatable($datatable);
            $responseService->getDatatableQueryBuilder();

            return $responseService->getResponse();
        }

        $form = $this->createFormBuilder()->getForm();

        return $this->renderForm('default/server-table.html.twig', [
            'datatable' => $datatable,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/tables/server/create", name="table_server_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $server = new Server();
        $form = $this->createForm(ServerType::class, $server);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($server);
            $entityManager->flush();

            $this->addFlash('success', 'La création a bien été prise en compte');

            return $this->redirectToRoute('table_server_list');
        }

        return $this->renderForm('default/server-edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Update server.
     *
     * @Route("/tables/server/edit/{id}", name="table_server_edit")
     */
    public function updateServer(Request $request, Server $server, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServerType::class, $server);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'La validation a bien été prise en compte');

            return $this->redirectToRoute('table_server_list');
        }

        return $this->renderForm('default/server-edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/tables/server/delete/{id}", name="table_server_delete", methods={"POST"})
     */
    public function delete(Request $request, Server $server, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($server);
            $entityManager->flush();

            $this->addFlash('success', 'La suppression a bien été prise en compte');

            return $this->redirectToRoute('table_server_list');
        }

        $this->addFlash('danger', 'Erreur lors de laa suppression');

        return $this->redirectToRoute('table_server_list');
    }
}
