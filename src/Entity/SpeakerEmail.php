<?php

namespace App\Entity;

use App\Repository\SpeakerEmailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpeakerEmailRepository::class)
 */
class SpeakerEmail
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
    private $speakerName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSave;

    /**
     * @ORM\ManyToMany(targetEntity=SupportContext::class, inversedBy="speakerEmails")
     */
    private $supportContext;

    public function __construct()
    {
        $this->supportContext = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpeakerName(): ?string
    {
        return $this->speakerName;
    }

    public function setSpeakerName(string $speakerName): self
    {
        $this->speakerName = $speakerName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateSave(): ?\DateTimeInterface
    {
        return $this->dateSave;
    }

    public function setDateSave(\DateTimeInterface $dateSave): self
    {
        $this->dateSave = $dateSave;

        return $this;
    }

    /**
     * @return Collection|SupportContext[]
     */
    public function getSupportContext(): Collection
    {
        return $this->supportContext;
    }

    public function addSupportContext(SupportContext $supportContext): self
    {
        if (!$this->supportContext->contains($supportContext)) {
            $this->supportContext[] = $supportContext;
        }

        return $this;
    }

    public function removeSupportContext(SupportContext $supportContext): self
    {
        if ($this->supportContext->contains($supportContext)) {
            $this->supportContext->removeElement($supportContext);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->speakerName;
    }
}
