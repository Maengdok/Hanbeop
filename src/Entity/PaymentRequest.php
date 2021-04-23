<?php

namespace App\Entity;

use App\Repository\PaymentRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRequestRepository::class)
 */
class PaymentRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paidAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $validated;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="paymentRequest", cascade={"persist", "remove"})
     */
    private $fromOrder;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripeSessionId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paidAt;
    }

    public function setPaidAt(?\DateTimeInterface $paidAt): self
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(?bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    public function getFromOrder(): ?Order
    {
        return $this->fromOrder;
    }

    public function setFromOrder(?Order $fromOrder): self
    {
        $this->fromOrder = $fromOrder;

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
    }
}
