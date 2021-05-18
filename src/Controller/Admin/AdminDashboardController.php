<?php

namespace App\Controller\Admin;

use App\Entity\Categoria;
use App\Entity\Cliente;
use App\Entity\Pedido;
use App\Entity\Producto;
use App\Entity\Usuario;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class AdminDashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Yishop');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Escritorio', 'fa fa-home'),
            MenuItem::linkToCrud('Clientes', 'fa fa-tags', Cliente::class),
            MenuItem::linkToCrud('Productos', 'fa fa-file-text', Producto::class),
            MenuItem::linkToCrud('Pedidos', 'fa fa-file-text', Pedido::class),
            MenuItem::linkToCrud('Usuarios', 'fa fa-file-text', Usuario::class),
            MenuItem::linkToCrud('Categorias', 'fa fa-file-text', Categoria::class)
        ];
    }
}
