<?php
namespace App\Conversations;

use App\Entity\Block;
use Cocur\Slugify\Slugify;
use App\Utils\Manager\DataRegister;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use App\Services\ContainerAwareConversationTrait;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class MainConversation extends Conversation
{
    use ContainerAwareConversationTrait;

    private $flowManager;
    private $blockManager;
    private $contentManager;
    private $actionManager;
    private $buttonManager;

    private $flow;
    private $currentBlock;
    private $nextBlock;
    private $previousBlock;

    public function run()
    {
        // Get current flow

        $this->flow = DataRegister::getInstance()->getData('flow');

        // Initialize managers
        $this->flowManager     = DataRegister::getInstance()->getData("flowManager");
        $this->blockManager    = DataRegister::getInstance()->getData("blockManager");
        $this->contentManager  = DataRegister::getInstance()->getData("contentManager");
        $this->actionManager   = DataRegister::getInstance()->getData("actionManager");
        $this->buttonManager   = DataRegister::getInstance()->getData("buttonManager");

        // get the Starter block of this flow
        $this->currentBlock = $this->blockManager->findStarterBlockByFlow($this->flow);

        $this->next($this->currentBlock);
    }

    public function next(Block $block)
    {
        $this->getBot()->types();

        if($block->getType() === 'Question'){
            $callbackId = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, 10);
            $question = Question::create($block->getContent()->getText());
            $question->fallback("unable to ask a question");
            $question->callbackId($callbackId);

            $data = $this->getButtons($block->getContent());
            $buttons = $data["botsButtons"];
            $contentsButtons = $data["contentsButtons"];

            if(!empty($buttons)){
                $question->addButtons($buttons);
            }

            $this->ask($question, function (Answer $answer) use ($block,$contentsButtons) {

                if(!empty($contentsButtons)){
                    if($answer->isInteractiveMessageReply()){
                        $value = $answer->getValue();
                        $button = null;

                        foreach ($contentsButtons as $btn) {
                            if($btn->getSlug() === $value){
                                $button = $btn;
                                break;
                            }
                        }
                        
                        
                        if( $value == $button->getSlug()){

                            if($button->getAction()->getNextBlock() !== null){
                                $this->next($button->getAction()->getNextBlock());
                            }

                            if($button->getAction()->getNextFlow() !== null){
                                $this->flow = $button->getAction()->getNextFlow();
                                $this->run();                                
                            }
                        }
                        // TODO Save user Entries
                    }
                }else{
                    // TODO Save user entries
                }
                
                if($block->getNextBlock() !== null){
                    $this->next($block->getNextBlock());
                }
            });
        }

        if($block->getType() === "Response"){

            $content = $block->getContent();

            DataRegister::getInstance()->getData('session')->set('Test',$content);

            $question = Question::create($content->getText());

            if(!empty($this->getAttachments($block->getContent()))){
                // processing of showing attachment
            }

            $this->say($question);

            if($block->getNextBlock() !== null){
                $this->next($block->getNextBlock());
            }
        }
        // TODO Default message
    }

    private function getButtons($content)
    {
        $buttons = [];
        $criterial = array('content' => $content);
        $contentsButtons = $this->buttonManager->findBy($criterial);

        if(!empty($contentsButtons)){
            $slugify = new Slugify();
            foreach($contentsButtons as $button){
                $buttons[] = Button::create($button->getName())->value($slugify->slugify($button->getName()));
            }
        }
        return array('contentsButtons' => $contentsButtons, 'botsButtons' => $buttons);
    }

    private function getAttachments($content)
    {
        // $contentAttachments = $this->contentManager->
    }

    private function getContent($block)
    {
        return $this->contentManager->findOneBy(array('block' => $block));
    }

}