<?php

namespace App\Controller\Admin;

use App\Entity\Producto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Configurator\MoneyConfigurator;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProductosCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Producto::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            
            TextField::new('nombre'),
            
            SlugField::new('url','URL Amigable')
                ->setTargetFieldName('nombre'),
            
            TextEditorField::new('descripcion','Descripción')
                ->setNumOfRows(10),
            
            MoneyField::new('precio','Precio')
                ->setCurrency('EUR')
                ->setNumDecimals(2)
                ->setStoredAsCents(true),
            
            NumberField::new('peso')
                ->addCssClass('field-money')
                ->setTextAlign(TextAlign::RIGHT)
                ->setNumDecimals(2),
            
            NumberField::new('cantidad')
                ->addCssClass('field-money')
                ->setTextAlign(TextAlign::RIGHT)
                ->setNumDecimals(2),
            
            BooleanField::new('activo')
                
        ];
    }
    
    

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            
            // Traducción
            ->setEntityLabelInSingular('Producto')
            ->setEntityLabelInPlural('Productos')
            
            // Formateo
            ->setDateFormat('d/m/Y')
            ->setNumberFormat('%.2d')
            
            // Búsqueda
            ->setSearchFields(['nombre', 'precio','cantidad'])
            
            ;
    }
}
