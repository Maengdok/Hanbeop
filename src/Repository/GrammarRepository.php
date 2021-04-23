<?php

namespace App\Repository;

use App\Entity\Grammar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Grammar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grammar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grammar[]    findAll()
 * @method Grammar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrammarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grammar::class);
    }

    // /**
    //  * @return Grammar[] Returns an array of Grammar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Grammar
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
