<?php
namespace App\Manager;

use App\Entity\Button;
use App\Manager\AbstractManager;

class ButtonManager extends AbstractManager
{
    public function findBy($criterial)
    {
        return $this->getRepository(Button::class)->findBy($criterial);
    }

    public function findOneBy($criterial)
    {
        return $this->getRepository(Button::class)->findOneBy($criterial);
    }

}