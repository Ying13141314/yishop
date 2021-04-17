<?php

namespace App\Controller\Admin;

use App\Entity\Cliente;
use App\Entity\Producto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            MenuItem::linkToCrud('Productos', 'fa fa-file-text', Producto::class)
        ];
    }
}
