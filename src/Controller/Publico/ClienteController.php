<?php

namespace App\Controller\Publico;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    /**
     * @Route("/cliente", name="cliente")
     */
    public function index(): Response
    {
        return $this->render('publico/cliente/index.html.twig', [
            'controller_name' => 'ClienteController',
        ]);
    }
}
