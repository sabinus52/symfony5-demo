<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Controller;

use App\Datatable\ServerTableType;
use App\Entity\Server;
use App\Form\ServerType;
use Doctrine\ORM\EntityManagerInterface;
use Olix\BackOfficeBundle\Helper\AutoCompleteService;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur des tables.
 *
 * @author Sabinus52 <sabinus52@gmail.com>
 */
class TablesServerController extends AbstractController
{
    #[Route(path: '/tables/server/list', name: 'table_server__list')]
    public function index(Request $request, DataTableFactory $factory): Response
    {
        $datatable = $factory->createFromType(ServerTableType::class, [], [
            'searching' => true,
        ])
            ->handleRequest($request)
        ;

        if ($datatable->isCallback()) {
            return $datatable->getResponse();
        }

        return $this->renderForm('tables/server-index.html.twig', [
            'datatable' => $datatable,
        ]);
    }

    #[Route(path: 'tables/addressip/ajax', name: 'addressip_ajax')]
    public function getSearchIPs(Request $request, AutoCompleteService $autoComplete): JsonResponse
    {
        $results = $autoComplete->getResults(ServerType::class, $request);

        return $this->json($results);
    }

    #[Route(path: '/tables/server/create', name: 'table_server__create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $server = new Server();
        $form = $this->createForm(ServerType::class, $server);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($server);
            $entityManager->flush();
            $this->addFlash('success', sprintf('La création du serveur <strong>%s</strong> a bien été prise en compte', $server));

            return $this->redirectToRoute('table_server_list');
        }

        return $this->renderForm('tables/server-edit.html.twig', [
            'form' => $form,
            'title' => 'Créer un nouveau serveur',
        ]);
    }

    /**
     * Update server.
     */
    #[Route(path: '/tables/server/edit/{id}', name: 'table_server__edit')]
    public function update(Request $request, Server $server, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServerType::class, $server);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', sprintf('La modification du serveur <strong>%s</strong> a bien été prise en compte', $server));

            return $this->redirectToRoute('table_server_list');
        }

        return $this->renderForm('tables/server-edit.html.twig', [
            'form' => $form,
            'title' => 'Formulaire d\'édition d\'un serveur',
        ]);
    }

    #[Route(path: '/tables/server/delete/{id}', name: 'table_server__delete')]
    public function remove(Request $request, Server $server, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($server);
            $entityManager->flush();
            $this->addFlash('success', sprintf('La suppression du serveur <strong>%s</strong> a bien été prise en compte', $server));

            return new Response('OK');
        }

        return $this->renderForm('@OlixBackOffice/Include/modal-content-delete.html.twig', [
            'form' => $form,
            'element' => sprintf('<strong>%s</strong>', $server),
        ]);
    }
}
