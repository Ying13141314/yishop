<?php

namespace App\Controller\Publico;

use App\Repository\ProductoRepository;
use App\Services\CarritoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarritoCompraController extends AbstractController
{
    private CarritoService $carrito;
    private ProductoRepository $productoRepository;

    public function __construct(CarritoService $carrito, ProductoRepository $productoRepository)
    {
        $this->carrito = $carrito;
        $this->productoRepository = $productoRepository;
    }

    /**
     * @Route("/carrito/compra", name="carrito_compra", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        $carrito = $session->get('productos');
        
        
        if (!$carrito)
            return $this->render('publico/carrito_compra/carritoVacio.html.twig');

        $productos = [];
        $subtotal = 0;

        foreach ($carrito as $id => $cantidades) {

            $producto = $this->productoRepository->find($id);

            foreach ($cantidades as $talla => $cantidad) {

                $producto->setCantidades($talla, $cantidad);

            }

            $productos[] = $producto;
            $subtotal += $producto->calcularTotal();

        }

        return $this->render('publico/carrito_compra/index.html.twig', [
            'controller_name' => 'CarritoCompraController',
            'productos' => $productos,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * @Route("/carrito", name="carrito.add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $id = $request->request->get('id');
        $cantidad = $request->request->get('cantidad');
        $talla = $request->request->get('talla');

        $session = $request->getSession();

        $carrito = $session->get('productos');
        
        if ($carrito) {
            
            $cantidad_original = $carrito[$id][$talla] ?? 0;

            $carrito[$id][$talla] = $cantidad + $cantidad_original;
            
        } else {
            
            $carrito[$id] = [
                $talla => $cantidad
            ];
            
        }
        
        $session->set('productos', $carrito);
        

        return $this->json($carrito);
    }

    /**
     * @Route("/carrito", name="carrito.add", methods={"DELETE"})
     */
    public function remove(Request $request): Response
    {
        $id = $request->request->get('id');

        $session = $request->getSession();

        $carrito = $session->get('productos');
        
        if (!$carrito) {
            return $this->json('error');
        }

        if (!isset($carrito[$id])) {
            return $this->json('error');
        }
        
        unset($carrito[$id]);

        $subtotal = 0;
        foreach ($carrito as $id => $cantidades) {

            $producto = $this->productoRepository->find($id);

            $productos[] = $producto;
            $subtotal += $producto->calcularTotal();

        }

        $subtotal = number_format($subtotal, 2, ',','');

        return $this->json("$subtotal €");
    }
}
