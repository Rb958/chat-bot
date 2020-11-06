<?php

namespace App\Repository;

use App\Entity\Intent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Intent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intent[]    findAll()
 * @method Intent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intent::class);
    }

    // /**
    //  * @return Intent[] Returns an array of Intent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Intent
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    /**
     * @param string $intentLabel
     * @return bool
     * @throws NonUniqueResultException
     */
    public function existsByLabel(string $intentLabel)
    {
        $result =  $this->createQueryBuilder('i')
            ->andWhere('i.label = :val')
            ->setParameter('val',$intentLabel)
            ->getQuery()
            ->getResult();
        return $result != null && !empty($result);
    }
}
