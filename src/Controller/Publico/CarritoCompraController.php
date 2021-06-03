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

        // comprobamos si hay carrito
        if (!$carrito)
            return $this->render('publico/carrito_compra/carritoVacio.html.twig');
        
        
        // tomamos si hay productos agotados
        $productosAgotados = $request->query->get('productosAgotados', []);
        
        
        // hacemos los calculos para la vista
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

        $session->set('subtotal', $subtotal);

        // renderizamos vista
        return $this->render('publico/carrito_compra/index.html.twig', [
            'controller_name' => 'CarritoCompraController',
            'productos' => $productos,
            'subtotal' => $subtotal,
            'productosAgotados' => $productosAgotados
        ]);
    }

    /**
     * @Route("/carrito", name="carrito_add", methods={"POST"})
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
     * @Route("/carrito/{productoId}", name="carrito_delete", methods={"DELETE"})
     */
    public function remove(int $productoId, Request $request): Response
    {
        $session = $request->getSession();

        $carrito = $session->get('productos');
        
        if (!$carrito) {
            return $this->json('error');
        }

        if (!isset($carrito[$productoId])) {
            return $this->json('error');
        }
        
        unset($carrito[$productoId]);
        
        $session->set('productos', $carrito);

        $subtotal = 0;
        
        foreach ($carrito as $id => $cantidades) {
            $producto = $this->productoRepository->find($id);

            foreach ($cantidades as $talla => $cantidad) {
                $producto->setCantidades($talla, $cantidad);
            }
            
            $subtotal += $producto->calcularTotal();
        }

        $session->set('subtotal', $subtotal);

        $subtotal = number_format($subtotal, 2, ',','');

        return $this->json("$subtotal €");
    }
}
