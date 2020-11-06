<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    // /**
    //  * @return Ticket[] Returns an array of Ticket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /**
     * Get tickets by Customer details
     * Customer details is a concatenation of his name and his customerID
     * @param $value
     * @return Ticket[]|null
     */
    public function findByCustomer($value): ?array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.customer = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Get one ticket by his code
     * @param string $value
     * @return Ticket|null
     * @throws NonUniqueResultException
     */
    public function findOneByCode(string $value): ?Ticket
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.code = :val')
            ->setParameter('val',$value)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
