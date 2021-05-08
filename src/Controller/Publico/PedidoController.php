<?php

namespace App\Controller\Publico;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PedidoController extends AbstractController
{
    /**
     * @Route("/pedido", name="pedido")
     */
    public function index(): Response
    {
        return $this->render('publico/pedido/index.html.twig', [
            'controller_name' => 'PedidoController',
        ]);
    }
}
