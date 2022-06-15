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
use App\Form\TestButtonType;
use App\Form\TestChoiceType;
use App\Form\TestDateTimePickerType;
use App\Form\TestDateTimeType;
use App\Form\TestOtherType;
use App\Form\TestSelect2Type;
use App\Form\TestTextType;
use App\Form\TestType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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
     * @Route("/addressip/ajax", name="addressip_ajax")
     */
    public function getSearchIPs(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $term = $request->get('term');
        $page = (int) $request->get('page', 0);

        /** @phpstan-ignore-next-line */
        $query = $entityManager->getRepository(AddressIP::class)->createQueryBuilder('m')
            ->andWhere('m.ip LIKE :val')
            ->setParameter('val', '%'.$term.'%')
            ->orderBy('m.ip', 'ASC')
        ;
        if (0 === $page) {
            $query = $query->getQuery();
            $addressips = $query->getResult();
        } else {
            $query = $query->setFirstResult(($page - 1) * 10)
                ->setMaxResults(10)
                ->getQuery()
            ;

            $addressips = new Paginator($query, true);
        }

        $results = [];
        foreach ($addressips as $value) {
            $results[] = [
                'id' => $value->getId(),
                'text' => $value->getIp(),
            ];
        }

        if (0 === $page) {
            $result = $results;
        } else {
            $result = [
                'results' => $results,
                'more' => (($page * 10) < count($addressips)),
            ];
        }

        return $this->json($result);
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
            $result = $form->getData();
            // Add this new user
            // $manager->setUser($form->getData())->add($form->get('password')->getData());

            // return $this->redirectToRoute('forms_test');
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            // $form->addError(new FormError('Tous les champs ne sont pas complètement remplis'));
            $this->addFlash('error', 'Tous les champs ne sont pas complètement remplis');
            $result = $form->getData();
        }

        return $this->renderForm('default/forms-test.html.twig', [
            'form' => $form,
            'result' => $result,
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
