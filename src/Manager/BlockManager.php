<?php
namespace App\Manager;

use App\Entity\Block;
use App\Manager\AbstractManager;

class BlockManager extends AbstractManager
{
    public function findStarterBlockByFlow($flow){
        $criterial = array('flow' => $flow, 'isStarter' => true);
        return $this->getRepository(Block::class)->findOneBy($criterial);
    }
}