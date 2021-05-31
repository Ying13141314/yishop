<?php

namespace App\Controller\Publico;

use App\Services\CarritoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarritoCompraController extends AbstractController
{
    private CarritoService $carrito;

    public function __construct(CarritoService $carrito)
    {
        $this->carrito = $carrito;
    }

    /**
     * @Route("/carrito/compra", name="carrito_compra", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        
        $productoId = '';
        if($session->get('productos')==null){
            return $this->render('publico/carrito_compra/carritoVacio.html.twig', [
            ]);
        }else{
            foreach ($session->get('productos') as $id => $valor) {
                $productoId = $id;
            }

            return $this->render('publico/carrito_compra/index.html.twig', [
                'controller_name' => 'CarritoCompraController',
                'productos' => $productoId
            ]);
        }
        
    }

    /**
     * @Route("/carrito", name="carrito.add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $id = $request->request->get('id');
        $cantidad = $request->request->get('cantidad');
        $talla = $request->request->get('talla');

        $producto[$id] = [
            $talla => $cantidad
        ];
        
        $request->getSession()->set('productos', $producto);

        return $this->json('ok');
    }
}
