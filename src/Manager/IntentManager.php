<?php
namespace App\Manager;

use App\Entity\Intent;

class IntentManager extends AbstractManager
{
    public function findBy($criterial)
    {
        return $this->getRepository(Intent::class)->findBy($criterial);
    }
}