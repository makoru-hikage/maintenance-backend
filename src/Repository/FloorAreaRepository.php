<?php

namespace App\Repository;

use App\Entity\FloorArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FloorArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method FloorArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method FloorArea[]    findAll()
 * @method FloorArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FloorAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FloorArea::class);
    }

    // /**
    //  * @return FloorArea[] Returns an array of FloorArea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FloorArea
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
