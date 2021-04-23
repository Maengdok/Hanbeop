<?php

namespace App\Entity;

use App\Repository\GrammarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GrammarRepository::class)
 */
class Grammar
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
     * @ORM\ManyToOne(targetEntity=Letter::class, inversedBy="grammars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $letter;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="grammars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Level::class, inversedBy="grammars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity=Exercice::class, mappedBy="grammar")
     */
    private $exercices;

    /**
     * @ORM\OneToMany(targetEntity=Meaning::class, mappedBy="grammar")
     */
    private $meanings;

    public function __construct()
    {
        $this->exercices = new ArrayCollection();
        $this->meanings = new ArrayCollection();
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

    public function getLetter(): ?Letter
    {
        return $this->letter;
    }

    public function setLetter(?Letter $letter): self
    {
        $this->letter = $letter;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection|Exercice[]
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
            $exercice->setGrammar($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): self
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getGrammar() === $this) {
                $exercice->setGrammar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Meaning[]
     */
    public function getMeanings(): Collection
    {
        return $this->meanings;
    }

    public function addMeaning(Meaning $meaning): self
    {
        if (!$this->meanings->contains($meaning)) {
            $this->meanings[] = $meaning;
            $meaning->setGrammar($this);
        }

        return $this;
    }

    public function removeMeaning(Meaning $meaning): self
    {
        if ($this->meanings->removeElement($meaning)) {
            // set the owning side to null (unless already changed)
            if ($meaning->getGrammar() === $this) {
                $meaning->setGrammar(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
