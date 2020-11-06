<?php

namespace App\Utils\BotMessage;

use App\Entity\Intent;
use App\Entity\Utterance;
use App\Repository\IntentRepository;
use App\Repository\UtteranceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class BotReply
{
    /**
     * @var IntentRepository
     */
    private $intentRepo;
    /**
     * @var UtteranceRepository
     */
    private $utteranceRepo;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public  function __construct(ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $managerRegistry->getManager();
        $this->intentRepo = $managerRegistry->getRepository(Intent::class);
        $this->utteranceRepo = $managerRegistry->getRepository(Utterance::class);
    }

    /**
     * Get an Utterance By intent name
     * @param $intentName
     * @param string $defaultMessage
     * @return string|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getMessage(string $intentName, string $defaultMessage){

        if (!$this->intentRepo->existsByLabel($intentName)){
            $newIntent = (new Intent())
                ->setLabel($intentName);
            $this->entityManager->persist($newIntent);

            if(!$this->utteranceRepo->existsUtteranceByText($defaultMessage)){
                $utterance = (new Utterance())
                    ->setIntent($newIntent)
                    ->setText($defaultMessage);

                $this->entityManager->persist($utterance);
                $this->entityManager->flush();
            }
        }

        if($intentName != null && trim($intentName) !== ""){
            $intent = $this->intentRepo->findOneBy(['label' => $intentName]);
            $utterances = $this->utteranceRepo->findBy(['intent' => $intent]);
            $bdUtteranceText = $utterances[rand(0,count($utterances) - 1)]->getText();

            return ($bdUtteranceText !== null && $bdUtteranceText !== "" ) ? $bdUtteranceText : $defaultMessage;
        }else{
            return $defaultMessage;
        }
    }
}