<?php


namespace App\Repository;

use App\Entity\DetallePedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetallePedido|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetallePedido|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetallePedido[]    findAll()
 * @method DetallePedido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetallePedido::class);
    }


    /**
     * @param $pedidoId
     * @return int|mixed[]|string
     * Obtenemos las cantidades, las tallas y el nombre del producto que se compraron en un pedido.
     */
    public function detalles($pedidoId)
    {
        $query = $this->createQueryBuilder('detalles')
            ->leftJoin('detalles.pedido', 'pedido')
            ->leftJoin('detalles.producto', 'producto')
            ->select('producto.nombre','detalles.talla','detalles.cantidad')
            ->where('pedido.id = :id')
            ->setParameter('id', $pedidoId)
            ->getQuery()->getArrayResult();

        return $query;
    }
    
}