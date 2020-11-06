<?php
namespace App\Controller;

use App\Utils\WitApi\Wit;
use BotMan\BotMan\BotMan;
use App\Manager\FlowManager;
use App\Manager\BlockManager;
use App\Services\FlowService;
use App\Manager\ActionManager;
use App\Manager\ButtonManager;
use App\Manager\IntentManager;
use App\Manager\ContentManager;
use BotMan\BotMan\BotManFactory;
use BotMan\Drivers\Web\WebDriver;
use App\Utils\BotMessage\BotReply;
use App\Utils\Manager\DataRegister;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use App\Utils\BotMessage\BotReplyFactory;
use Doctrine\Persistence\ManagerRegistry;
use App\Conversations\ConversationsManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use Symfony\Component\HttpFoundation\Response;
use BotMan\Drivers\Telegram\TelegramFileDriver;
use Symfony\Component\Routing\Annotation\Route;
use BotMan\Drivers\Telegram\TelegramPhotoDriver;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BotController extends AbstractController{
    private $messagePattern = "{message}";
    /**
     * @var BotReply
     */
    private $botReply;
    private $flowManager;
    private $flowService;
    private $intentManager;
    private $blockManager;
    private $contentManager;
    private $actionManager;
    private $buttonManager;

    public function __construct(
        FlowManager $flowManager, 
        FlowService $flowService, 
        IntentManager $intentManager,
        BlockManager $blockManager,
        ContentManager $contentManager,
        ActionManager $actionManager,
        ButtonManager $buttonManager
    )
    {
        $this->flowManager    = $flowManager;
        $this->flowService    = $flowService;
        $this->intentManager  = $intentManager;
        $this->blockManager   = $blockManager;
        $this->contentManager = $contentManager;
        $this->actionManager  = $actionManager;
        $this->buttonManager  = $buttonManager;
    }

    /**
     * @Route("/bot", name="message")
     * @return Response
     */
    public function botMessage(ManagerRegistry $managerRegistry,SessionInterface $session){
        DriverManager::loadDriver(WebDriver::class);
        DriverManager::loadDriver(TelegramDriver::class);
        DriverManager::loadDriver(TelegramFileDriver::class);
        DriverManager::loadDriver(TelegramPhotoDriver::class);


	/*
		Telegram integration with ngrok
		curl -X POST -F 'url=https://{YOU_URL}/bot' https://api.telegram.org/bot1319493766:AAE50pEoe3GlVB5e7UykGrcy0_P1u3GpYFo/setWebhook
	*/

        $config = [
            'telegram' => [
                'token' => '1319493766:AAE50pEoe3GlVB5e7UykGrcy0_P1u3GpYFo'
            ]
        ];

        DataRegister::getInstance()->setData('session', $session);

        $adapter = new FilesystemAdapter();
        $botman  = BotManFactory::create($config, new SymfonyCache($adapter));

            $botman->hears($this->messagePattern, function (BotMan $bot, $message) {
                $response = Wit::create("3SCITC44HDW3XIRFT3ONKXTJUNSTSOQW")->sendText($message);
    
                if($response != null){
                    $conversationsManager = new ConversationsManager(
                        $bot, 
                        $this->flowService, 
                        $this->flowManager,
                        $this->intentManager,
                        $this->blockManager,
                        $this->contentManager,
                        $this->actionManager, 
                        $this->buttonManager  
                    );
                    $conversationsManager->open($response,$this->getDoctrine());
                }else{
                    $bot->reply(BotReplyFactory::createBotReply()->getMessage('dont_understand',"Je ne vous comprend pas"));
                }
            });

        $botman->listen();

        return new Response();
    }

    /**
     * @Route("/chat-frame", name="chatframe")
     */
    public function chatFrame(){
        return $this->render('bot/index.html.twig');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homePage(){
        $startMessage = "Salut! Je suis AFP Bot que puis-je faire pour vous?";
        return $this->render('bot/home.html.twig', ['startMessage' => $startMessage]);
    }
}
