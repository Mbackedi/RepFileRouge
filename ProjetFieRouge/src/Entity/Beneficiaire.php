<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeneficiaireRepository")
 */
class Beneficiaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomb;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephoneb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseb;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $numpieceb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typepieceb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="beneficiaire")
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomb(): ?string
    {
        return $this->nomb;
    }

    public function setNomb(string $nomb): self
    {
        $this->nomb = $nomb;

        return $this;
    }

    public function getPrenomb(): ?string
    {
        return $this->prenomb;
    }

    public function setPrenomb(string $prenomb): self
    {
        $this->prenomb = $prenomb;

        return $this;
    }

    public function getTelephoneb(): ?int
    {
        return $this->telephoneb;
    }

    public function setTelephoneb(int $telephoneb): self
    {
        $this->telephoneb = $telephoneb;

        return $this;
    }

    public function getAdresseb(): ?string
    {
        return $this->adresseb;
    }

    public function setAdresseb(string $adresseb): self
    {
        $this->adresseb = $adresseb;

        return $this;
    }

    public function getNumpieceb(): ?int
    {
        return $this->numpieceb;
    }

    public function setNumpieceb(?int $numpieceb): self
    {
        $this->numpieceb = $numpieceb;

        return $this;
    }

    public function getTypepieceb(): ?string
    {
        return $this->typepieceb;
    }

    public function setTypepieceb(?string $typepieceb): self
    {
        $this->typepieceb = $typepieceb;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setBeneficiaire($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getBeneficiaire() === $this) {
                $transaction->setBeneficiaire(null);
            }
        }

        return $this;
    }
}
