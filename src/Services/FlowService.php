<?php

namespace App\Services;

use App\Conversations\MainConversation;
use App\Entity\Flow;
use App\Manager\AttachmentManager;
use App\Manager\BlockManager;
use App\Manager\ButtonManager;
use BotMan\BotMan\BotMan;
use Cocur\Slugify\Slugify;
use App\Manager\FlowManager;
use App\Manager\ContentManager;
use Symfony\Component\Filesystem\Filesystem;
use App\Utils\ClassGenerator\ClassCodeBuilder;
use App\Utils\ClassGenerator\FunctionCodeBuilder;

class FlowService 
{

    private $flowManager;
    private $contentmanager;
    private $buttonManager;
    private $attachmentmanager;
    private $blockManager;

    public function __construct(
        FlowManager $flowManager, 
        ContentManager $contentManager,
        ButtonManager $buttonManager, 
        AttachmentManager $attachmentManager,
        BlockManager $blockManager)
    {
        $this->flowManager = $flowManager;
        $this->contentmanager = $contentManager;
        $this->buttonManager = $buttonManager;
        $this->attachmentmanager = $attachmentManager;
        $this->blockManager = $blockManager;
    }

    public function execute(Flow $flow, BotMan $bot){
        //$fullClassname = "App\Conversations\\" . ucfirst(str_replace(' ', '', ucwords($flow->getName())));
        //$bot->startConversation(new $fullClassname);

        $bot->startConversation(new MainConversation());
    }

    private function createFlowConversation(Flow $flow)
    {
        $generatedClass = new ClassCodeBuilder();

        $function = new FunctionCodeBuilder();

        $blockStarter = $this->blockManager->findStarterBlockByFlow($flow);

        $starterName = $blockStarter->getTitle();
        $functionname = str_replace(' ', '', lcfirst(ucwords($starterName)));
        $functionBody = <<<EOF
\$this->{$functionname}();
EOF;
        $function->setFunctionName('run')
        ->setBody($functionBody);
        $generatedClass->addFunction($function);

        foreach($flow->getBlocks() as $block){
            if($block->getType() == 'Question'){
            $functionBody = <<<EOF
\$this->getBot()->types();
\t\$q1 = Question::create(BotReplyFactory::createBotReply()->getMessage('{$flow->getIntent()->getLabel()}','{$block->getContents()[0]->getText()}'))
\t\t->fallback("unable to ask a question")
\t\t->callbackId("ask_{$block->getTitle()}"){$this->getFormatedButtons($block)};
\t\$this->ask(\$q1, function(Answer \$answer) {
\t\t\t{$this->hasButtons($block)}
{$this->getFormatedNextBlock($block->getNextBlock())}
\t});
EOF;
            }else{

                $functionBody = <<<EOF
\$this->getBot()->types();
{$this->getBlockContents($block)};
{$this->getFormatedNextBlock($block->getNextBlock())}
EOF;
            }

            $function = (new FunctionCodeBuilder())
                ->setFunctionName($block->getTitle())
                ->setBody($functionBody)
                ;
            $generatedClass->addFunction($function);

        }

        $generatedClass->setNamespace("App\Conversations")
        ->setClasseNameExtended("Conversation")
        ->addImport("App\Utils\BotMessage\BotReplyFactory")
        ->addImport("BotMan\BotMan\Messages\Incoming\Answer")
        ->addImport("BotMan\BotMan\Messages\Outgoing\Question")
        ->addImport("BotMan\BotMan\Messages\Outgoing\Actions\Button")
        ->addImport("BotMan\BotMan\Messages\Conversations\Conversation")
        ->setClassname($flow->getName())
        ;

        return $generatedClass->render();
    }


    private function getBlockContents($block){
        $contents = $this->contentmanager->findAllBy(array('block' => $block));
    
        $text = "";

        foreach($contents as $content){
            // $attachments = $this->attachmentmanager->findBy(array('content' => $content));
            $text = ($content->getText() != '') ? "\$this->say(\"" . $content->getText() ."\")" : "";
        }
        return $text;
    }

    private function getFormatedNextBlock($block){
        $formatedNext = '';

        if($block != null){
            $formatedNext = "\t\t\$this->" . str_replace(' ', '', lcfirst(ucwords($block->getTitle()))) . "();";
        }

        return $formatedNext;
    }

    public function generateFlow(Flow $flow)
    {
        $generatedClass = $this->createFlowConversation($flow);
        $fs = new Filesystem();
        $directory = dirname(__DIR__)."/Conversations";
        $fileName = "";

        if($fs->exists($directory)){

            $fileName = $directory."/".str_replace(' ','',ucwords($flow->getName())).".php";

        }else{

            $fs->mkdir($directory);

            $fileName = $directory."/".str_replace(' ','',ucwords($flow->getName())).".php";
        }

        $fs->touch($fileName);
        $fs->dumpFile($fileName,$generatedClass);

        $flow->setIsActivate(true);

        $this->flowManager->save($flow);
    }

    private function getFormatedButtons($block)
    {
        $formatedButtons = '';

        $criterial = array('block' => $block);
        $contents = $this->contentmanager->findAllBy($criterial);
        $buttons = [];
        foreach ($contents as $content) {
            $btnresult = $this->buttonManager->findBy(array('content' => $content));
            if(!empty($btnresult)) $buttons[] = $btnresult;
        }

        if(!empty($buttons)){
            $formatedButtons .= "->addButtons([";
        }
        foreach ($buttons as $btns) {
            foreach ($btns as $button) {
                $slug = new Slugify();
                $formatedButtons .= "Button::create('{$button->getName()}')->value('{$slug->slugify($button->getName())}'),";
            }
        }

        if(!empty($buttons)){
            $formatedButtons .= "])";
        }

        return $formatedButtons;
    }

    private function hasButtons($block){

        $answer = '';

        $formatedButtons = '';

        $criterial = array('block' => $block);
        $contents = $this->contentmanager->findAllBy($criterial);
        $buttons = [];
        foreach ($contents as $content) {
            $buttons[] = $this->buttonManager->findBy(array('content' => $content));
            // dd($this->buttonManager->findBy(array('content' => $content)));
        }

        if(!empty($buttons)){
            foreach ($buttons as $btns) {
                /**
                 * @var Button $button
                 */
                foreach ($btns as $button) {
                    
                    if($button->getAction() != null and $button->getAction()->getNextBlock() != null){
                        $slug = new Slugify();
                        $next = $button->getAction()->getNextBlock();
                        $answer .= <<<EOF
if (\$answer->isInteractiveMessageReply()){
    if(\$answer->getValue() === "{$slug->slugify($button->getName())}"){
        {$this->getFormatedNextBlock($next)}
    }
}
EOF;
                    }

                }
            }
        }
        return $answer;
    }
}