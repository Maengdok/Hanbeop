<?php

namespace App\Entity;

use App\Repository\LetterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LetterRepository::class)
 */
class Letter
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
     * @ORM\Column(type="string", length=255)
     */
    private $symbol;

    /**
     * @ORM\OneToMany(targetEntity=Grammar::class, mappedBy="letter")
     */
    private $grammars;

    public function __construct()
    {
        $this->grammars = new ArrayCollection();
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

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @return Collection|Grammar[]
     */
    public function getGrammars(): Collection
    {
        return $this->grammars;
    }

    public function addGrammar(Grammar $grammar): self
    {
        if (!$this->grammars->contains($grammar)) {
            $this->grammars[] = $grammar;
            $grammar->setLetter($this);
        }

        return $this;
    }

    public function removeGrammar(Grammar $grammar): self
    {
        if ($this->grammars->removeElement($grammar)) {
            // set the owning side to null (unless already changed)
            if ($grammar->getLetter() === $this) {
                $grammar->setLetter(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->symbol;
    }
}
