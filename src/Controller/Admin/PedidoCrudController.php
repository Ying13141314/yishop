<?php

namespace App\Controller\Admin;

use App\Entity\Pedido;
use App\Repository\ClienteRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PedidoCrudController extends AbstractCrudController
{
    private ClienteRepository $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Pedido::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $campos = [
            IdField::new('id')->hideOnForm(),

            ChoiceField::new('estado')
                ->setLabel('Estado')
                ->allowMultipleChoices(false)
                ->setChoices([
                    'En Proceso' => Pedido::EN_PROCESO,
                    'Recibido' => Pedido::RECIBIDO,
                    'Cancelado' => Pedido::CANCELADO,
                    'Enviado' => Pedido::ENVIADO,
                ]),

            TextField::new('direccion'),

            TextField::new('codigo_postal'),

            ChoiceField::new('idCliente')
                ->setLabel('Clientes')
                ->allowMultipleChoices(false)
                ->setChoices($this->clienteRepository->getChoices()),
        ];

        return $campos;
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);

        $cliente = $this->clienteRepository->find($entityInstance->getIdClienteRaw());
        $entityInstance->setCliente($cliente);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);
        
        $cliente = $this->clienteRepository->find($entityInstance->getIdClienteRaw());
        $entityInstance->setCliente($cliente);
        $entityManager->flush();
    }
}
