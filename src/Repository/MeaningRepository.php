<?php

namespace App\Repository;

use App\Entity\Meaning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Meaning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meaning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meaning[]    findAll()
 * @method Meaning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeaningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meaning::class);
    }

    // /**
    //  * @return Meaning[] Returns an array of Meaning objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Meaning
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
