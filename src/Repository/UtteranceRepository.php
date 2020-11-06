<?php

namespace App\Repository;

use App\Entity\Utterance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Utterance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utterance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utterance[]    findAll()
 * @method Utterance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtteranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utterance::class);
    }

    // /**
    //  * @return Utterance[] Returns an array of Utterance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Utterance
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
