<?php

namespace App\Entity;

use App\Repository\UtteranceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtteranceRepository::class)
 */
class Utterance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=Intent::class, inversedBy="utterances")
     * @ORM\JoinColumn(name="intent_fk", nullable=false)
     */
    private $intent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getIntent(): ?Intent
    {
        return $this->intent;
    }

    public function setIntent(?Intent $intent): self
    {
        $this->intent = $intent;

        return $this;
    }

    public function __toString()
    {
        return $this->text;
    }
}
