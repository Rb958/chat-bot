<?php

namespace App\Manager;

use App\Entity\Flow;

class FlowManager extends AbstractManager
{
    private $repo;

    public function find($id){
        return $this->getRepository(Flow::class)->find($id);
    }

    public function findOneBy($criterial)
    {
        return $this->getRepository(Flow::class)->findOneBy($criterial);
    }

    public function findAllBy($criterial){
        return $this->getRepository(Flow::class)->findBy($criterial);
    }

    public function findBy($criterial)
    {
        return $this->getRepository(Flow::class)->findBy($criterial);
    }
}