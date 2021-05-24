<?php

namespace App\Controller\Publico;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginClinteController extends AbstractController
{
    /**
     * @Route("/login/clinte", name="login_clinte")
     */
    public function index(): Response
    {
        return $this->render('publico/login_clinte/index.html.twig', [
            'controller_name' => 'LoginClinteController',
        ]);
    }
}