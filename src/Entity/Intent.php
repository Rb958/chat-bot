<?php

namespace App\Entity;

use App\Repository\IntentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IntentRepository::class)
 */
class Intent
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
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Utterance::class, mappedBy="intent", orphanRemoval=true)
     */
    private $utterances;

    /**
     * @ORM\OneToMany(targetEntity=Flow::class, mappedBy="intent")
     */
    private $flows;

    public function __construct()
    {
        $this->utterances = new ArrayCollection();
        $this->flows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Utterance[]
     */
    public function getUtterances(): Collection
    {
        return $this->utterances;
    }

    public function addUtterance(Utterance $utterance): self
    {
        if (!$this->utterances->contains($utterance)) {
            $this->utterances[] = $utterance;
            $utterance->setIntent($this);
        }

        return $this;
    }

    public function removeUtterance(Utterance $utterance): self
    {
        if ($this->utterances->contains($utterance)) {
            $this->utterances->removeElement($utterance);
            // set the owning side to null (unless already changed)
            if ($utterance->getIntent() === $this) {
                $utterance->setIntent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flow[]
     */
    public function getFlows(): Collection
    {
        return $this->flows;
    }

    public function addFlow(Flow $flow): self
    {
        if (!$this->flows->contains($flow)) {
            $this->flows[] = $flow;
            $flow->setIntent($this);
        }

        return $this;
    }

    public function removeFlow(Flow $flow): self
    {
        if ($this->flows->contains($flow)) {
            $this->flows->removeElement($flow);
            // set the owning side to null (unless already changed)
            if ($flow->getIntent() === $this) {
                $flow->setIntent(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->label;
    }
}
