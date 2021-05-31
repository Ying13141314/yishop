<?php


namespace App\Controller\Admin;

use App\Entity\Talla;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TallaCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Talla::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $campos = [
            IdField::new('id')->hideOnForm(),

            TextField::new('nombre')
        ];
        return $campos;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            // Traducción
            ->setEntityLabelInSingular('Talla')
            ->setEntityLabelInPlural('Tallas')

            // Formateo
            ->setDateFormat('d/m/Y')
            ->setNumberFormat('%.2d')

            // Búsqueda
            ->setSearchFields(['nombre']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(CRUD::PAGE_INDEX, 'detail');
    }

}