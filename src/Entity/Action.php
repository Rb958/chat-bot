<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 */
class Action
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Flow::class, fetch="EAGER")
     */
    private $nextFlow;

    /**
     * @ORM\ManyToOne(targetEntity=Block::class, fetch="EAGER")
     */
    private $nextBlock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNextFlow(): ?Flow
    {
        return $this->nextFlow;
    }

    public function setNextFlow(?Flow $nextFlow): self
    {
        $this->nextFlow = $nextFlow;

        return $this;
    }

    public function getNextBlock(): ?Block
    {
        return $this->nextBlock;
    }

    public function setNextBlock(?Block $nextBlock): self
    {
        $this->nextBlock = $nextBlock;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
