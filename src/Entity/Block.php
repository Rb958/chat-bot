<?php

namespace App\Entity;

use App\Repository\BlockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlockRepository::class)
 */
class Block
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
    private $title;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isStarter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Flow::class, inversedBy="blocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $flow;

    /**
     * @ORM\OneToOne(targetEntity=Block::class, inversedBy="previousBlock", cascade={"persist", "remove"})
     */
    private $nextBlock;

    /**
     * @ORM\OneToOne(targetEntity=Block::class, mappedBy="nextBlock", cascade={"persist", "remove"})
     */
    private $previousBlock;

    /**
     * @ORM\OneToOne(targetEntity=Content::class, inversedBy="block", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $content;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIsStarter(): ?bool
    {
        return $this->isStarter;
    }

    public function setIsStarter(bool $isStarter): self
    {
        $this->isStarter = $isStarter;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFlow(): ?Flow
    {
        return $this->flow;
    }

    public function setFlow(?Flow $flow): self
    {
        $this->flow = $flow;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getNextBlock(): ?self
    {
        return $this->nextBlock;
    }

    public function setNextBlock(?self $nextBlock): self
    {
        $this->nextBlock = $nextBlock;

        return $this;
    }

    public function getPreviousBlock(): ?self
    {
        return $this->previousBlock;
    }

    public function setPreviousBlock(?self $previousBlock): self
    {
        $this->previousBlock = $previousBlock;

        // set (or unset) the owning side of the relation if necessary
        $newNextBlock = null === $previousBlock ? null : $this;
        if ($previousBlock->getNextBlock() !== $newNextBlock) {
            $previousBlock->setNextBlock($newNextBlock);
        }

        return $this;
    }

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(Content $content): self
    {
        $this->content = $content;

        return $this;
    }
}
