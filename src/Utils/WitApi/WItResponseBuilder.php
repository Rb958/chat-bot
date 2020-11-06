<?php


namespace App\Utils\WitApi;


/**
 * Construct a Wit Response
 * @package App\Utils\WitApi
 */
class WItResponseBuilder
{
    private $text;
    private $intents;
    private $entities;
    private $traits;

    /**
     * Build WitResponse object
     * @return WitResponse
     */
    public  function build(): WitResponse
    {
        return new WitResponse($this);
    }

    /**
     * Set the message
     * @param string $param
     * @return WItResponseBuilder
     */
    public function setText(string $param): WItResponseBuilder
    {
        $this->text = $param;
        return $this;
    }

    /**
     * Set intents
     * @param array $intents
     * @return WItResponseBuilder
     */
    public function setIntents(array $intents): WItResponseBuilder
    {
        $this->intents = $intents;
        return $this;
    }

    /**
     * Set entities
     * @param array $entities
     * @return WItResponseBuilder
     */
    public function setEntities(array $entities): WItResponseBuilder
    {
        $this->entities = $entities;
        return $this;
    }

    /**
     * Set Traits
     * @param array $traits
     * @return WItResponseBuilder
     */
    public function setTraits(array $traits): WItResponseBuilder
    {
        $this->traits = $traits;
        return $this;
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
     * @return array
     */
    public function getEntities()
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
}