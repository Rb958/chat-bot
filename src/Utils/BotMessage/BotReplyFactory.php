<?php


namespace App\Utils\BotMessage;

use Doctrine\Persistence\ManagerRegistry;

class BotReplyFactory
{

    private static $botReply;

    public static function createBotReply(){
        if(self::$botReply == null){
            global $kernel;
            $kernel->boot();
            $doctrine = $kernel->getContainer()->has('doctrine') ? $kernel->getContainer()->get('doctrine') : null;
            /** @var ManagerRegistry $doctrine */
            self::$botReply = new BotReply($doctrine);
        }

        return self::$botReply;
    }
}