<?php
namespace App\Manager;

use App\Entity\SonataMediaMedia;

class AttachmentManager extends AbstractManager
{
    public function findBy($criteria)
    {
        return $this->getRepository(SonataMediaMedia::class)->findBy($criteria);
    }
}