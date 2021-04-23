<?php

namespace App\Entity;

use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LevelRepository::class)
 */
class Level
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
     * @ORM\OneToMany(targetEntity=Grammar::class, mappedBy="level")
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
            $grammar->setLevel($this);
        }

        return $this;
    }

    public function removeGrammar(Grammar $grammar): self
    {
        if ($this->grammars->removeElement($grammar)) {
            // set the owning side to null (unless already changed)
            if ($grammar->getLevel() === $this) {
                $grammar->setLevel(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
