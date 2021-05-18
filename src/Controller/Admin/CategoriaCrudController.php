<?php

namespace App\Controller\Admin;

use App\Entity\Categoria;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CategoriaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categoria::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $campos = [
            IdField::new('id')->hideOnForm(),

            TextField::new('nombre'),

            BooleanField::new('con_talla'),
            
            BooleanField::new('principal')
        ];
        return $campos;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            // Traducción
            ->setEntityLabelInSingular('Categoría')
            ->setEntityLabelInPlural('Categorías')

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
