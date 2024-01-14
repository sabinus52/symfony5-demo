<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur des menus.
 *
 * @author Sabinus52 <sabinus52@gmail.com>
 */
class TablesMenuController extends AbstractController
{
    #[Route(path: '/tables/menus', name: 'table_menu_list')]
    public function index(MenuRepository $repository): Response
    {
        return $this->render('tables/menu-index.html.twig', [
            'menus' => $repository->findAll(),
        ]);
    }

    #[Route(path: '/tables/menus/create', name: 'table_menu_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu, [
            'action' => $this->generateUrl('table_menu_create'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($menu);
            $entityManager->flush();
            $this->addFlash('success', sprintf('La création du menu <strong>%s</strong> a bien été prise en compte', $menu->getLabel()));

            return new Response('OK');
        }

        return $this->renderForm('tables/menu-edit.html.twig', [
            'form' => $form,
            'title' => 'Créer un nouveau menu',
        ]);
    }

    #[Route(path: '/tables/menus/edit/{id}', name: 'table_menu_edit', methods: ['GET', 'POST'])]
    public function update(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', sprintf('La modification du menu <strong>%s</strong> a bien été prise en compte', $menu->getLabel()));

            return new Response('OK');
        }

        return $this->renderForm('tables/menu-edit.html.twig', [
            'form' => $form,
            'title' => 'Modifier un menu',
        ]);
    }

    #[Route(path: '/tables/menus/remove/{id}', name: 'table_menu_remove')]
    public function remove(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($menu);
            $entityManager->flush();
            $this->addFlash('success', sprintf('La suppression du menu <strong>%s</strong> a bien été prise en compte', $menu->getLabel()));

            return new Response('OK');
        }

        return $this->renderForm('@OlixBackOffice/Include/modal-content-delete.html.twig', [
            'form' => $form,
            'element' => sprintf('<strong>%s</strong>', $menu->getLabel()),
        ]);
    }
}
