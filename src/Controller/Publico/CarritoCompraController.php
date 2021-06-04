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
    private ProductoRepository $productoRepository;

    /**
     * CarritoCompraController constructor.
     * @param ProductoRepository $productoRepository
     * Constructor
     */
    public function __construct(ProductoRepository $productoRepository)
    {
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

        // renderizamos la vista
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
        //obtenemos los datos de la petición del usuario
        $id = $request->request->get('id');
        $cantidad = $request->request->get('cantidad');
        $talla = $request->request->get('talla');

        $session = $request->getSession();

        //obtenemos el carrito de la sessión
        $carrito = $session->get('productos');
        
        //Si existe el carrito sumamos lo nuevo a lo antiguo
        if ($carrito) {
            
            $cantidad_original = $carrito[$id][$talla] ?? 0;

            $carrito[$id][$talla] = $cantidad + $cantidad_original;
            // en otro caso lo creamos
        } else {
            
            $carrito[$id] = [
                $talla => $cantidad
            ];
            
        }
        
        //Guardamos el nuevo carrito
        $session->set('productos', $carrito);
        

        return $this->json($carrito);
    }

    /**
     * @Route("/carrito/{productoId}", name="carrito_delete", methods={"DELETE"})
     */
    public function remove(int $productoId, Request $request): Response
    {
        //obtenemos el carrito
        $session = $request->getSession();

        $carrito = $session->get('productos');
        
        //Comprobamos el carrito
        if (!$carrito) {
            return $this->json('error');
        }

        if (!isset($carrito[$productoId])) {
            return $this->json('error');
        }
        
        //Eliminamos el producto del carrito
        unset($carrito[$productoId]);
        
        //Guardamos el carrito con el producto que hemos eliminado
        $session->set('productos', $carrito);

        //Recalculamos el subtotal
        $subtotal = 0;
        
        foreach ($carrito as $id => $cantidades) {
            $producto = $this->productoRepository->find($id);

            foreach ($cantidades as $talla => $cantidad) {
                $producto->setCantidades($talla, $cantidad);
            }
            
            $subtotal += $producto->calcularTotal();
        }

        //guardar el subtotal nuevo
        $session->set('subtotal', $subtotal);

        $subtotal = number_format($subtotal, 2, ',','');

        return $this->json("$subtotal €");
    }
}
