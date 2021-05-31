<?php

namespace App\Controller\Admin;

use App\Entity\Categoria;
use App\Entity\Cliente;
use App\Entity\Pedido;
use App\Entity\Producto;
use App\Entity\Talla;
use App\Entity\Usuario;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
{

    private AdminUrlGenerator $url;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->url = $adminUrlGenerator;
    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Yishop');
    }

    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        return $this->redirect($this->url->setController(UsuarioCrudController::class)->generateUrl());
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToCrud('Clientes', 'fa fa-tags', Cliente::class),
            MenuItem::linkToCrud('Productos', 'fa fa-file-text', Producto::class),
            MenuItem::linkToCrud('Pedidos', 'fa fa-file-text', Pedido::class),
            MenuItem::linkToCrud('Usuarios', 'fa fa-file-text', Usuario::class),
            MenuItem::linkToCrud('Categorias', 'fa fa-file-text', Categoria::class),
            MenuItem::linkToCrud('Tallas', 'fa fa-file-text', Talla::class)
        ];
    }
}
