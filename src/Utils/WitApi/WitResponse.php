<?php


namespace App\Utils\WitApi;


class WitResponse
{
    private $text;
    /**
     * @var array
     */
    private $intents;
    /**
     * @var array
     */
    private $entities;
    /**
     * @var array
     */
    private $traits;

    public function __construct(WItResponseBuilder $builder)
    {
        $this->text = $builder->getText();
        $this->intents = $builder->getIntents();
        $this->entities = $builder->getEntities();
        $this->traits = $builder->getTraits();
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getIntents()
    {
        return $this->intents;
    }

    /**
     * @return WitEntity[]|null
     */
    public function getEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @return array
     */
    public function getTraits()
    {
        return $this->traits;
    }

    /**
     * @return WitIntent|null
     */
    public function getBestIntent()
    {
        $best = null;
        if(isset($this->intents) and is_array($this->intents) and !empty($this->intents)){
            $best = $this->intents[0];

            foreach ($this->intents as $intent){
                if($intent->getConfidence() > 0.5 and $best->getConfidence() < $intent->getConfidence()){
                    $best = $intent;
                }
            }
        }
        return $best;
    }

    public function __toString(){
        $obj_str =  " WitResponse : { ";

        $obj_str .= "Text : " . $this->text . ",";

        $obj_str .= "Intents : [";

        foreach($this->intents as $intent){
            $obj_str .= "{";
            $obj_str .= "id : ". $intent->getId() . ",";
            $obj_str .= "name : ". $intent->getName() . ",";
            $obj_str .= "confidence : ". $intent->getConfidence();
            $obj_str .= "}";
        }
        $obj_str .= "],";

        $obj_str.= "Entities : [ ";
         
        foreach ($this->entities as $entity){
            $obj_str .= "{";
            $obj_str .= "id : " . $entity->getId() . ",";
            $obj_str .= "name : " . $entity->getName() . ",";
            $obj_str .= "role : " . $entity->getRole() . ",";
            $obj_str .= "start : " . $entity->getStart() . ",";
            $obj_str .= "end : " . $entity->getEnd() . ",";
            $obj_str .= "body : " . $entity->getBody() . ",";
            $obj_str .= "confidence : " . $entity->getConfidence() . ",";
            $obj_str .= "entities : " . $entity->getEntities() . ",";
            $obj_str .= "value : " . $entity->getValue() . ",";
            $obj_str .= "type : " . $entity->getType();
            $obj_str .= "}";
        }

        $obj_str .= "],";

        $obj_str .= "Trais : []";

        return $obj_str;
    }
}