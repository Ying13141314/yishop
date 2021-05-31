<?php

namespace App\Controller\Admin;

use App\Entity\Categoria;
use App\Entity\Producto;
use App\Form\ImagenType;
use App\Repository\CategoriaRepository;
use App\Repository\TallaRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductosCrudController extends AbstractCrudController
{
    private CategoriaRepository $categoriaRepository;
    private TallaRepository $tallaRepository;

    public function __construct(CategoriaRepository $categoriaRepository, TallaRepository $tallaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
        $this->tallaRepository = $tallaRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Producto::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $campos = [
            IdField::new('id')->hideOnForm(),

            TextField::new('nombre'),

            SlugField::new('url', 'URL Amigable')
                ->setTargetFieldName('nombre'),

            TextEditorField::new('descripcion', 'Descripción')
                ->setNumOfRows(10),

            MoneyField::new('precio', 'Precio')
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

            ChoiceField::new('categoriasIds')
                ->setLabel('Categorías')
                ->allowMultipleChoices()
                ->setChoices($this->categoriaRepository->getChoices()),
            
            ChoiceField::new('tallasIds')
                ->setLabel('Tallas')
                ->allowMultipleChoices()
                ->setChoices($this->tallaRepository->getChoices()),

            
            BooleanField::new('activo')
        ];

        if ($pageName === CRUD::PAGE_DETAIL) {

            // Para mostrar los ficheros en los detalles
            $campos[] = CollectionField::new('imagenes')
                ->setTemplatePath('admin/imagenes.html.twig')
                ->onlyOnDetail();

        } elseif ($pageName === CRUD::PAGE_EDIT || $pageName === CRUD::PAGE_NEW) {

            // Para subir ficheros múltiples en el formulario
            $campos[] = CollectionField::new('imagenes')
                ->setEntryType(ImagenType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms();

        }


        return $campos;
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
            ->setSearchFields(['nombre', 'precio', 'cantidad']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(CRUD::PAGE_INDEX, 'detail');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);

        $this->insertCategorias($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->insertCategorias($entityManager, $entityInstance, true);
        
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function insertCategorias(EntityManagerInterface $entityManager, $entityInstance, bool $actualizar = false)
    {
        $productoId = $entityInstance->getId();

        if ($actualizar) {
            $entityManager->getConnection()->executeQuery("DELETE FROM categorias_productos  WHERE producto_id = :productoId", [
                'productoId' => $productoId,
            ]);
        }
        
        foreach ($entityInstance->getCategoriasIds() as $categoriasId) {
            $entityManager->getConnection()->executeQuery("INSERT INTO categorias_productos VALUE (0, :categoriaId, :productoId)", [
                'productoId' => $productoId,
                'categoriaId' => $categoriasId
            ]);
        }
    }

}
