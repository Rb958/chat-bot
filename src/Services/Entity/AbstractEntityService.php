<?php


namespace App\Services\Entity;


use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractEntityService
{
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        $this->entityManager = $this->managerRegistry->getManager();
    }
}