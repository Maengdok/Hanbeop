<?php

namespace App\Entity;

use App\Repository\FormulationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormulationRepository::class)
 */
class Formulation
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
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Meaning::class, inversedBy="formulations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $meaning;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getMeaning(): ?Meaning
    {
        return $this->meaning;
    }

    public function setMeaning(?Meaning $meaning): self
    {
        $this->meaning = $meaning;

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->content;
    }
}
