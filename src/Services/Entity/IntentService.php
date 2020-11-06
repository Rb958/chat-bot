<?php


namespace App\Services\Entity;


use App\Entity\Intent;
use App\Repository\IntentRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class IntentService extends AbstractEntityService
{
    /**
     * @var IntentRepository
     */
    private $intentRepo;

    /**
     * Save Intent
     * @param Intent $intent
    //  * @return Intent
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveIntent(Intent $intent){
        $this->entityManager->flush($intent);
    }

    /**
     * Verify if Intent exist
     * @param $intentLabel string
     * @return bool
     */
    public function intentExist($intentLabel): bool {
        return $this->intentRepo->existsByLabel($intentLabel);
    }
}