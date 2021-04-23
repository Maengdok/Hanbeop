<?php

namespace App\Repository;

use App\Entity\Formulation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formulation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formulation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formulation[]    findAll()
 * @method Formulation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formulation::class);
    }

    // /**
    //  * @return Formulation[] Returns an array of Formulation objects
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
    public function findOneBySomeField($value): ?Formulation
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
