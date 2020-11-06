<?php


namespace App\Utils\WitApi;


class WitEntity
{
    private $id;
    private $name;
    private $role;
    private $start;
    private $end;
    private $body;
    private $confidence;
    private $entities;
    private $value;
    private $type;

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
    public function setId(string $id): void
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
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @param int $start
     */
    public function setStart(int $start): void
    {
        $this->start = $start;
    }

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }

    /**
     * @param int $end
     */
    public function setEnd(int $end): void
    {
        $this->end = $end;
    }

    /**
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return float
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }

    /**
     * @param float $confidence
     */
    public function setConfidence(float $confidence): void
    {
        $this->confidence = $confidence;
    }

    /**
     * @return WitEntity[]|null
     */
    public function getEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @param WitEntity[] $entities
     */
    public function setEntities(array $entities): void
    {
        $this->entities = $entities;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


    public function __toString(){
            $obj_str = "Entity : {";
            $obj_str .= "id : " . $this->getId() . ",";
            $obj_str .= "name : " . $this->getName() . ",";
            $obj_str .= "role : " . $this->getRole() . ",";
            $obj_str .= "start : " . $this->getStart() . ",";
            $obj_str .= "end : " . $this->getEnd() . ",";
            $obj_str .= "body : " . $this->getBody() . ",";
            $obj_str .= "confidence : " . $this->getConfidence() . ",";
            $obj_str .= "entities : " . $this->getEntities() . ",";
            $obj_str .= "value : " . $this->getValue() . ",";
            $obj_str .= "type : " . $this->getType();
            $obj_str .= "}";

            return $obj_str;
    }

}