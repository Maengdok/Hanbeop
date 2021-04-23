<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $period;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="subscription")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=PaymentRequest::class, mappedBy="fromOrder", cascade={"persist", "remove"})
     */
    private $paymentRequest;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function setPeriod(int $period): self
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setSubscription($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSubscription() === $this) {
                $user->setSubscription(null);
            }
        }

        return $this;
    }

    public function getPaymentRequest(): ?PaymentRequest
    {
        return $this->paymentRequest;
    }

    public function setPaymentRequest(?PaymentRequest $paymentRequest): self
    {
        // unset the owning side of the relation if necessary
        if ($paymentRequest === null && $this->paymentRequest !== null) {
            $this->paymentRequest->setFromOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($paymentRequest !== null && $paymentRequest->getFromOrder() !== $this) {
            $paymentRequest->setFromOrder($this);
        }

        $this->paymentRequest = $paymentRequest;

        return $this;
    }
}
