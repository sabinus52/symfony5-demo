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
use App\Entity\Server;
use App\Form\TestButtonType;
use App\Form\TestChoiceType;
use App\Form\TestDateTimePickerType;
use App\Form\TestDateTimeType;
use App\Form\TestOtherType;
use App\Form\TestSelect2Type;
use App\Form\TestTextType;
use App\Form\TestType;
use App\Repository\ServerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Olix\BackOfficeBundle\Helper\AutoCompleteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur de base.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.ElseExpression)
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
        ]);
    }

    /**
     * @Route("/forms/vertical", name="forms_vertical")
     */
    public function viewFormVertical(): Response
    {
        $formText = $this->createForm(TestTextType::class);
        $formChoice = $this->createForm(TestChoiceType::class);
        $formSelect2 = $this->createForm(TestSelect2Type::class);
        $formDateTime = $this->createForm(TestDateTimeType::class);
        $formDateTimePicker = $this->createForm(TestDateTimePickerType::class);
        $formOther = $this->createForm(TestOtherType::class);
        $formButton = $this->createForm(TestButtonType::class);

        return $this->renderForm('default/forms-vertical.html.twig', [
            'formText' => $formText,
            'formChoice' => $formChoice,
            'formSelect2' => $formSelect2,
            'formDateTime' => $formDateTime,
            'formDateTimePicker' => $formDateTimePicker,
            'formOther' => $formOther,
            'formButton' => $formButton,
        ]);
    }

    /**
     * @Route("/forms/horizontal", name="forms_horizontal")
     */
    public function viewFormHorizontal(): Response
    {
        $formText = $this->createForm(TestTextType::class);
        $formChoice = $this->createForm(TestChoiceType::class);
        $formSelect2 = $this->createForm(TestSelect2Type::class);
        $formDateTime = $this->createForm(TestDateTimeType::class);
        $formDateTimePicker = $this->createForm(TestDateTimePickerType::class);
        $formOther = $this->createForm(TestOtherType::class);
        $formButton = $this->createForm(TestButtonType::class);

        return $this->renderForm('default/forms-horizontal.html.twig', [
            'formText' => $formText,
            'formChoice' => $formChoice,
            'formSelect2' => $formSelect2,
            'formDateTime' => $formDateTime,
            'formDateTimePicker' => $formDateTimePicker,
            'formOther' => $formOther,
            'formButton' => $formButton,
        ]);
    }

    /**
     * @Route("/addressip/ajax", name="form_test_select2_ajax")
     */
    public function getSearchIPs(Request $request, AutoCompleteService $autoComplete): JsonResponse
    {
        $results = $autoComplete->getResults(TestSelect2Type::class, $request);

        return $this->json($results);
    }

    /**
     * @Route("/addressip/test/ajax", name="form_test_ajax")
     */
    public function getSearchIPs2(Request $request, AutoCompleteService $autoComplete): JsonResponse
    {
        $results = $autoComplete->getResults(TestType::class, $request);

        return $this->json($results);
    }

    /**
     * @Route("/forms/test", name="forms_test")
     */
    public function testForm(Request $request): Response
    {
        $result = null;

        $form = $this->createForm(TestType::class, [
            'text' => 'Type your message here',
            // 'ajax_ips' => $entity,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'La validation a bien été pris en compte');

            return $this->redirectToRoute('forms_test');
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Tous les champs ne sont pas complètement remplis');
            $result = $form->getData();
        }

        return $this->renderForm('default/forms-test.html.twig', [
            'form' => $form,
            'result' => $result,
        ]);
    }

    /**
     * @Route("/forms/modal", name="forms_modal")
     */
    public function formModal(): Response
    {
        return $this->renderForm('default/forms-modal.html.twig');
    }

    /**
     * @Route("/forms/modal-test", name="forms_modal_test")
     */
    public function testFormModal(Request $request): Response
    {
        $form = $this->createForm(TestType::class);
        $form->remove('steps');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'La validation a bien été pris en compte');

            return $this->redirectToRoute('forms_test');
        }

        return $this->renderForm('default/forms-test-modal.html.twig', [
            'form' => $form,
            'title' => 'Formulaire modal',
        ]);
    }

    /**
     * @Route("/autocomplete", options={"expose": true}, name="sidebar_autocomplete")
     */
    public function autocompleteSideBar(Request $request, ServerRepository $repository): JsonResponse
    {
        $term = $request->get('query');

        /** @var Server[] $items */
        $items = $repository->createQueryBuilder('m')
            ->andWhere('m.hostname LIKE :val')
            ->setParameter('val', '%'.$term.'%')
            ->orderBy('m.hostname', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'value' => $item->getFqdn(),
                'data' => $item->getId(),
            ];
        }

        return $this->json([
            'query' => $term,
            'suggestions' => $result,
        ]);
    }

    /**
     * @Route("/toto", name="toto")
     */
    public function toto(): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
        ]);
    }

    /**
     * @Route("/link21", name="home21")
     */
    public function index21(): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
        ]);
    }

    /**
     * @Route("/link22", name="home22")
     */
    public function index22(): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
        ]);
    }

    /**
     * @Route("/link23", name="home23")
     */
    public function index23(): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
        ]);
    }

    /**
     * @Route("/link31", name="home31")
     */
    public function index31(): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
        ]);
    }

    /**
     * @Route("/link32", name="home32")
     */
    public function index32(): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
        ]);
    }

    /**
     * @Route("/notif/{id}", name="notif_one")
     *
     * @param mixed $id
     */
    public function notifOne($id): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
            'id' => $id,
        ]);
    }

    /**
     * @Route("/notif/all", name="notif_all")
     */
    public function notifAll(): Response
    {
        $options = $this->getParameter('olix_back_office');

        return $this->render('default/index.html.twig', [
            'options' => $options,
        ]);
    }
}
