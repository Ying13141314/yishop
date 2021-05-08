<?php

namespace App\Controller\Publico;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/productos")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/", name="productos",methods={"GET"})
     */
    public function index(Environment $twig, ProductoRepository $ProductoRepository): Response
    {
        return new Response($twig->render('Publico/producto/index.html.twig', [
            'productos' => $ProductoRepository->findAll(),
        ]));
    }

    /**
     * @Route("/{url}", name="producto",methods={"GET"})
     * @ParamConverter("producto", options={"mapping": {"url": "url"}})
     */
    public function show(Environment $twig, Producto $producto): Response
    {
        return new Response($twig->render('Publico/producto/show.html.twig', [
            'producto' => $producto,
        ]));
    }
}
