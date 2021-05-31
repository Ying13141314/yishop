<?php

namespace App\Controller\Publico;

use App\Entity\Cliente;
use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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

    /**
     * @Route("/cliente/update", name="cliente_update",methods={"POST"})
     */
    public function update(Request $request, UserInterface $cliente, ClienteRepository $clienteRepository): Response
    {
        $datos = $request->request->all();
        $clienteRepository->update($cliente,$datos);
        return $this->json('ok');
        
    }
}
