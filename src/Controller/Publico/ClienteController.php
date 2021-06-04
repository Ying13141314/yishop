<?php

namespace App\Controller\Publico;

use App\Repository\ClienteRepository;
use App\Repository\PedidoRepository;
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
    public function index(Request $request, UserInterface $cliente, PedidoRepository $repo): Response
    {
        
        //obtener los pedidos por el cliente y ordenado descendente
        $pedidos = $repo->findBy(['cliente' => $cliente],['fecha' => 'desc']);
        
        //Llevamos el pedido a la vista que hemos renderizado
        return $this->render('publico/cliente/index.html.twig', [
            'pedidos' => $pedidos,
        ]);
    }

    /**
     * @Route("/cliente/update", name="cliente_update",methods={"POST"})
     */
    public function update(Request $request, UserInterface $cliente, ClienteRepository $clienteRepository): Response
    {
        //obtenemos todos los parámetros que el usuario actualiza en su formulario de perfil
        $datos = $request->request->all();
        //Actualizamos con los nuevos datos
        $clienteRepository->update($cliente,$datos);
        return $this->json('ok');
        
    }
}
