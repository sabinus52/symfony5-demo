<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
     */
    public function notifOne($id): Response
    {
        $options = $this->getParameter('olix_back_office');
        return $this->render('default/index.html.twig', [
            'options' => $options,
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
