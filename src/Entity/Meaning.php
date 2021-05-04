<?php

namespace App\Entity;

use App\Repository\MeaningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeaningRepository::class)
 */
class Meaning
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
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Grammar::class, inversedBy="meanings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grammar;

    /**
     * @ORM\OneToMany(targetEntity=Example::class, mappedBy="meaning")
     */
    private $examples;

    /**
     * @ORM\OneToMany(targetEntity=Formulation::class, mappedBy="meaning")
     */
    private $formulations;

    public function __construct()
    {
        $this->examples = new ArrayCollection();
        $this->formulations = new ArrayCollection();
    }

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

    public function getGrammar(): ?Grammar
    {
        return $this->grammar;
    }

    public function setGrammar(?Grammar $grammar): self
    {
        $this->grammar = $grammar;

        return $this;
    }

    /**
     * @return Collection|Example[]
     */
    public function getExamples(): Collection
    {
        return $this->examples;
    }

    public function addExample(Example $example): self
    {
        if (!$this->examples->contains($example)) {
            $this->examples[] = $example;
            $example->setMeaning($this);
        }

        return $this;
    }

    public function removeExample(Example $example): self
    {
        if ($this->examples->removeElement($example)) {
            // set the owning side to null (unless already changed)
            if ($example->getMeaning() === $this) {
                $example->setMeaning(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formulation[]
     */
    public function getFormulations(): Collection
    {
        return $this->formulations;
    }

    public function addFormulation(Formulation $formulation): self
    {
        if (!$this->formulations->contains($formulation)) {
            $this->formulations[] = $formulation;
            $formulation->setMeaning($this);
        }

        return $this;
    }

    public function removeFormulation(Formulation $formulation): self
    {
        if ($this->formulations->removeElement($formulation)) {
            // set the owning side to null (unless already changed)
            if ($formulation->getMeaning() === $this) {
                $formulation->setMeaning(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->grammar->getTitle() . " - " . $this->content;
    }
}
