<?php


namespace App\Services\Entity;


use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class TicketService extends AbstractEntityService
{
    /**
     * @var TicketRepository
     */
    private $TiketRepo;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry);
        $this->TiketRepo = $managerRegistry->getRepository(Ticket::class);
    }

    /**
     * Persist the new Ticket into the database
     * @param Ticket $ticket
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createTicket(Ticket $ticket){
        $this->entityManager->persist($ticket);
        $this->entityManager->flush();
    }

    /**
     * Get customer's tickets
     * $customerDetails is a concatenation of the name the customer and his ID
     * @param $customerDetails
     * @return Ticket[]|null
     */
    public function getTiketsByCustomer($customerDetails): ?array
    {
        return $this->TiketRepo->findByCustomer($customerDetails);
    }

    /**
     * Get ticket by his code
     * @param string $code
     * @return Ticket|null
     * @throws NonUniqueResultException
     */
    public function getTiketByCode(string $code){
        return $this->TiketRepo->findOneByCode($code);
    }
}