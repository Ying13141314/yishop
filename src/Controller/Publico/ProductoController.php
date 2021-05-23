<?php

namespace App\Controller\Publico;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productos")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/categoria/{tipo}", name="productos.listado",methods={"GET"})
     */
    public function listado(Request $request,string $tipo, ProductoRepository $productoRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset'));
        $search = $request->query->get('search', '');
        
        $paginator = $productoRepository->getAll($offset, $tipo, $search);
        
        $next = min(count($paginator), $offset + ProductoRepository::PAGINATOR_PER_PAGE);
        $maybeMax = ceil(count($paginator) / ProductoRepository::PAGINATOR_PER_PAGE + 1 );
        
        return new Response($this->renderView('/publico/producto/listado.html.twig', [
            'productos' => $paginator,
            'tipo' => $tipo,
            'previous' => $offset - ProductoRepository::PAGINATOR_PER_PAGE,
            'next' => $next,
            'actualPage' => ceil($offset / ProductoRepository::PAGINATOR_PER_PAGE + 1),
            'max' => max($next, $maybeMax),
            'search' => $search
        ]));
    }
    
    /**
     * @Route("/{url}", name="productos.detalles",methods={"GET"})
     * @ParamConverter("producto", options={"mapping": {"url": "url"}})
     */
    public function detalles(Producto $producto): Response
    {
        return new Response($this->renderView('/publico/producto/detalles.html.twig', [
            'producto' => $producto,
        ]));
    }

}
