<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity=Button::class, mappedBy="content")
     */
    private $buttons;

    /**
     * @ORM\ManyToMany(targetEntity=SonataMediaMedia::class)
     */
    private $attachment;

    /**
     * @ORM\OneToOne(targetEntity=Block::class, mappedBy="content", cascade={"persist", "remove"})
     */
    private $block;

    public function __construct()
    {
        $this->buttons = new ArrayCollection();
        $this->attachment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|Button[]
     */
    public function getButtons(): Collection
    {
        return $this->buttons;
    }

    public function addButton(Button $button): self
    {
        if (!$this->buttons->contains($button)) {
            $this->buttons[] = $button;
            $button->setContent($this);
        }

        return $this;
    }

    public function removeButton(Button $button): self
    {
        if ($this->buttons->contains($button)) {
            $this->buttons->removeElement($button);
            // set the owning side to null (unless already changed)
            if ($button->getContent() === $this) {
                $button->setContent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SonataMediaMedia[]
     */
    public function getAttachment(): Collection
    {
        return $this->attachment;
    }

    public function addAttachment(SonataMediaMedia $attachment): self
    {
        if (!$this->attachment->contains($attachment)) {
            $this->attachment[] = $attachment;
        }

        return $this;
    }

    public function removeAttachment(SonataMediaMedia $attachment): self
    {
        if ($this->attachment->contains($attachment)) {
            $this->attachment->removeElement($attachment);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->text;
    }

    public function getBlock(): ?Block
    {
        return $this->block;
    }

    public function setBlock(Block $block): self
    {
        $this->block = $block;

        // set the owning side of the relation if necessary
        if ($block->getContent() !== $this) {
            $block->setContent($this);
        }

        return $this;
    }
}
