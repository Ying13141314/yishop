<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoria[]    findAll()
 * @method Categoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    /**
     * @return array
     * Obtenemos las categorias en una array asociativo de la forma nombre => id para poder mostrarla en el select del panel admin.
     */
    public function getChoices(): array
    {
        $lista = $this->createQueryBuilder('c', 'c.nombre')
            ->getQuery()->getArrayResult();

        foreach ($lista as $key => $item) {
            $lista[$key] = $item['id'];
        }
        
        return $lista;
    }
}
