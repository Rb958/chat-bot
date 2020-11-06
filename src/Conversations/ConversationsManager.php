<?php


namespace App\Conversations;


use BotMan\BotMan\BotMan;
use App\Manager\FlowManager;
use App\Manager\BlockManager;
use App\Services\FlowService;
use App\Manager\ActionManager;
use App\Manager\ButtonManager;
use App\Manager\IntentManager;
use Doctrine\ORM\ORMException;
use App\Manager\ContentManager;
use App\Utils\WitApi\WitResponse;
use App\Utils\BotMessage\BotReply;
use App\Utils\Manager\DataRegister;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

class ConversationsManager
{

    private $botman;
    private $flowManager;
    private $flowService;
    private $intentManager;

    public function __construct(
        BotMan $botMan, 
        FlowService $flowService, 
        FlowManager $flowManager, 
        IntentManager $intentManager,
        BlockManager $blockManager,
        ContentManager $contentManager,
        ActionManager $actionManager,
        ButtonManager $buttonManager
        )
    {
        $this->botman         = $botMan;
        $this->flowService    = $flowService;
        $this->flowManager    = $flowManager;
        $this->blockManager   = $blockManager;
        $this->contentManager = $contentManager;
        $this->actionManager  = $actionManager;
        $this->buttonManager  = $buttonManager;
        $this->intentManager  = $intentManager;
    }

    /**
     * @param WitResponse $response
     * @param ManagerRegistry $managerRegistry
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function open(WitResponse $response, ManagerRegistry $managerRegistry){
        $intent = $response->getBestIntent();
        $entitiesName = [];
        $botReply = new BotReply($managerRegistry);

        $entities = $response->getEntities();
        if(!empty($entities)){
            foreach ($entities as $entity){
                $entitiesName[] = $entity->getName();
            }
        }

        if($intent != null){
            $knowIntent = $this->intentManager->findBy(array("label" => $intent->getName()));
            $criterial = array("intent" => $knowIntent);
            $flow = $this->flowManager->findOneBy($criterial);

            if($flow != null){

                DataRegister::getInstance()->setData('flow', $flow);
                DataRegister::getInstance()->setData('flowManager', $this->flowManager);
                DataRegister::getInstance()->setData('blockManager', $this->blockManager);
                DataRegister::getInstance()->setData('contentManager', $this->contentManager);
                DataRegister::getInstance()->setData('actionManager', $this->actionManager);
                DataRegister::getInstance()->setData('buttonManager', $this->buttonManager);

                if($flow->getIsActivate()){
                    $this->flowService->execute($flow, $this->botman);
                }else{
                    $this->botman->reply("Desole je ne peux vous repondre sur ce sujet pour le moment");
                }

            }
        } else{
            $this->botman->types();
            $this->botman->reply($botReply->getMessage('incomprehension',"Desole mais je ne comprend pas votre intention"));
        }
    }
}