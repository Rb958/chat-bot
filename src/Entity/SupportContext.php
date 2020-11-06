<?php

namespace App\Entity;

use App\Repository\SupportContextRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupportContextRepository::class)
 */
class SupportContext
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
     * @ORM\Column(type="date")
     */
    private $dateSave;

    /**
     * @ORM\ManyToMany(targetEntity=SpeakerEmail::class, mappedBy="supportContext")
     */
    private $speakerEmails;

    public function __construct()
    {
        $this->speakerEmails = new ArrayCollection();
    }

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
     * @return Collection|SpeakerEmail[]
     */
    public function getSpeakerEmails(): Collection
    {
        return $this->speakerEmails;
    }

    public function addSpeakerEmail(SpeakerEmail $speakerEmail): self
    {
        if (!$this->speakerEmails->contains($speakerEmail)) {
            $this->speakerEmails[] = $speakerEmail;
            $speakerEmail->addSupportContext($this);
        }

        return $this;
    }

    public function removeSpeakerEmail(SpeakerEmail $speakerEmail): self
    {
        if ($this->speakerEmails->contains($speakerEmail)) {
            $this->speakerEmails->removeElement($speakerEmail);
            $speakerEmail->removeSupportContext($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
