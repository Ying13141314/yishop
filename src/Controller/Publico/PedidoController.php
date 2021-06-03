<?php

namespace App\Controller\Publico;

use App\Entity\Cliente;
use App\Entity\DetallePedido;
use App\Entity\Pedido;
use App\Repository\PedidoRepository;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;

class PedidoController extends AbstractController
{
    /**
     * PedidoController constructor.
     */
    public function __construct()
    {
        date_default_timezone_set("Europe/Madrid");
    }


    /**
     * @Route("/pedido", name="pedido", methods={"GET"})
     */
    public function index(Request $request, UserInterface $cliente): Response
    {
        $session = $request->getSession();

        $carrito = $session->get('productos');
        $subtotal = $session->get('subtotal');


        if (!$carrito)
            return $this->render('publico/carrito_compra/carritoVacio.html.twig');
        
        
        return $this->render('publico/pedido/index.html.twig', [
            'cliente' => $cliente,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * @Route("/pedido", name="pedido_crear", methods={"POST"})
     */
    public function crear(Request $request, UserInterface $cliente, ProductoRepository $productoRepository): Response
    {
//        if (!$cliente instanceof Cliente) {
//            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($cliente)));
//        }
//        
//        $session = $request->getSession();
//        $carrito = $session->get('productos');
//
//        if (!$carrito)
//            return new RedirectResponse('/carrito/compra');
//
//
//        // comprobación cantidad
//        $productosAgotados = [];
//        
//        foreach ($carrito as $idProducto => $cantidades) {
//            $producto = $productoRepository->find($idProducto);
//            
//            foreach ($cantidades as $talla => $cantidad) {
//                
//                if ($talla === "") {
//                    $cantidadActual = $producto->getCantidad();
//                } else {
//                    $cantidadActual = $producto->getCantidadDeTalla($talla);
//                }
//                
//                $cantidadRestante = $cantidadActual - $cantidad;
//                
//                if ($cantidadRestante < 0) {
//                    $productosAgotados[$idProducto][$talla] = [
//                        'cantidad' => $cantidad,
//                        'cantidadActual' => $cantidadActual
//                    ];
//                }
//            }
//        }
//
//        if (count($productosAgotados) > 0) {
//            
//            
//            
//            return 'hola';
//        }
        

        // generación pedido
        $entityManager = $this->getDoctrine()->getManager();
        $pedido = new Pedido();
        $pedido->setFecha(new \DateTime());
        $pedido->setCodigoPostal($cliente->getCodigoPostal());
        $pedido->setDireccion($cliente->getDireccion());
        $pedido->setEstado(Pedido::EN_PROCESO);
        $pedido->setCliente($cliente);
        
        $entityManager->persist($pedido);
        $entityManager->flush();
        
        
        foreach ($carrito as $idProducto => $cantidades) {
            $producto = $productoRepository->find($idProducto);
            $precio = $producto->getPrecio();


            foreach ($cantidades as $talla => $cantidad) {
                
                $detalles = new DetallePedido();

                $detalles->setCantidad($cantidad);
                $detalles->setTalla($talla === '' ? 'sin talla' : $talla);
                $detalles->setPedido($pedido);
                $detalles->setPrecioUnidad($precio);
                $detalles->setProducto($producto);

                $entityManager->persist($detalles);
                $entityManager->flush();
                
            }
            
        }

        $session->clear();

        return new RedirectResponse('/cliente');
    }
    
}
