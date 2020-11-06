<?php


namespace App\Utils\WitApi;


class WitIntent
{
    private $id;
    private $name;
    private $confidence;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getConfidence(): string
    {
        return $this->confidence;
    }

    /**
     * @param string $confidence
     */
    public function setConfidence($confidence): void
    {
        $this->confidence = $confidence;
    }


}