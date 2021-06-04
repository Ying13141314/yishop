<?php

namespace App\Repository;

use App\Entity\CategoriasProductos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriasProductos|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriasProductos|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriasProductos[]    findAll()
 * @method CategoriasProductos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriasProductosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriasProductos::class);
    }
}
