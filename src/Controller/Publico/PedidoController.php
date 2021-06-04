<?php

namespace App\Controller\Publico;

use App\Entity\Cliente;
use App\Entity\DetallePedido;
use App\Entity\Pedido;
use App\Repository\DetalleRepository;
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
    public function index(Request $request, UserInterface $cliente, ProductoRepository $productoRepository): Response
    {
        $session = $request->getSession();

        $carrito = $session->get('productos');
        $subtotal = $session->get('subtotal');

        if (!$carrito)
            return new RedirectResponse('/carrito/compra');

        // Creamos un array vacio para guardar los productos que se van a agotar.
        $productosAgotados = [];

        //Procesamos los datos del carrito para saber si se intentar comprar más producto de lo que hay.
        foreach ($carrito as $idProducto => $cantidades) {
            $producto = $productoRepository->find($idProducto);
            $nombreProducto = $producto->getNombre();

            foreach ($cantidades as $talla => $cantidad) {

                if ($talla === "") {
                    $cantidadActual = $producto->getCantidad();
                } else {
                    $cantidadActual = $producto->getCantidadDeTalla($talla);
                }

                $cantidadRestante = $cantidadActual - $cantidad;

                if ($cantidadRestante < 0) {
                    $productosAgotados[$nombreProducto][$talla] = [
                        'cantidad' => $cantidad,
                        'cantidadActual' => $cantidadActual
                    ];
                }
            }
        }

        //Si hay productos agotado enviamos otra vez al carrito
        if (count($productosAgotados) > 0) {
            return $this->redirect($this->generateUrl('carrito_compra', ['productosAgotados' => $productosAgotados]));
        }

        //renderizamos la vista
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
        if (!$cliente instanceof Cliente) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($cliente)));
        }

        $session = $request->getSession();
        $carrito = $session->get('productos');

        if (!$carrito)
            return new RedirectResponse('/carrito/compra');


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

        // generación detalles de pedido
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

                // se resta la cantidad comprada a los productos

                if ($talla === '') {
                    $cantidadActual = $producto->getCantidad();
                    $producto->setCantidad($cantidadActual - $cantidad);
                } else {
                    $cantidadActual = $producto->getCantidadDeTalla($talla);
                    $producto->setCantidadDeTalla($talla, $cantidadActual - $cantidad);
                }

                $entityManager->persist($producto);
                $entityManager->flush();
            }

        }

        //Se limpia la sessión para limpiar el carrito
        $session->clear();

        return new RedirectResponse('/cliente');
    }

    /**
     * @Route("/pedido/{id}/detalles", name="pedido_detalles", methods={"GET"})
     */
    public function detalles(int $id, DetalleRepository $detalleRepository, PedidoRepository $pedidoRepository)
    {
        //obtenemos el detalle de los productos comprado.
        $detalles = $detalleRepository->detalles($id);
        
        return $this->json($detalles);
    }

}
