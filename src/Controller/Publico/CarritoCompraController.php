<?php

namespace App\Controller\Publico;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarritoCompraController extends AbstractController
{
    /**
     * @Route("/carrito/compra", name="carrito_compra")
     */
    public function index(): Response
    {
        return $this->render('publico/carrito_compra/index.html.twig', [
            'controller_name' => 'CarritoCompraController',
        ]);
    }
}
