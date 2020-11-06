<?php
namespace App\Manager;

use App\Entity\Content;

class ContentManager extends AbstractManager
{
    public function findAllBy($criterial)
    {
        return $this->getRepository(Content::class)->findBy($criterial);
    }

    public function findOneBy($criterial){
        return $this->getRepository(Content::class)->findOneBy($criterial);
    }
}