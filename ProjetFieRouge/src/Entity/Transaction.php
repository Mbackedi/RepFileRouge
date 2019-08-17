<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Envoyeur;
use App\Entity\Beneficiaire;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

   

    /**
     * @ORM\Column(type="bigint")
     */
    private $code;

    /**
     * @ORM\Column(type="bigint")
     */
    private $montant;

    /**
     * @ORM\Column(type="bigint")
     */
    private $frais;

    /**
     * @ORM\Column(type="bigint")
     */
    private $total;

    /**
     * @ORM\Column(type="bigint")
     */
    private $commissionsup;

    /**
     * @ORM\Column(type="bigint")
     */
    private $commissionparte;

    /**
     * @ORM\Column(type="bigint")
     */
    private $commissionetat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datedenvoie;

    /**
     * @ORM\Column(type="datetime" ,nullable=true)
     */
    private $dateretrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typedoperation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Envoyeur", inversedBy="transactions")
     */
    private $envoyeur;

  

    /**
     * @ORM\Column(type="bigint")
     */
    private $numerotransacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Beneficiaire", inversedBy="transactions")
     */
    private $beneficiaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caissier;

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCommissionsup(): ?int
    {
        return $this->commissionsup;
    }

    public function setCommissionsup(int $commissionsup): self
    {
        $this->commissionsup = $commissionsup;

        return $this;
    }

    public function getCommissionparte(): ?int
    {
        return $this->commissionparte;
    }

    public function setCommissionparte(int $commissionparte): self
    {
        $this->commissionparte = $commissionparte;

        return $this;
    }

    public function getCommissionetat(): ?int
    {
        return $this->commissionetat;
    }

    public function setCommissionetat(int $commissionetat): self
    {
        $this->commissionetat = $commissionetat;

        return $this;
    }

    public function getDatedenvoie(): ?\DateTimeInterface
    {
        return $this->datedenvoie;
    }

    public function setDatedenvoie(\DateTimeInterface $datedenvoie): self
    {
        $this->datedenvoie = $datedenvoie;

        return $this;
    }

    public function getDateretrait(): ?\DateTimeInterface
    {
        return $this->dateretrait;
    }

    public function setDateretrait(\DateTimeInterface $dateretrait): self
    {
        $this->dateretrait = $dateretrait;

        return $this;
    }

    public function getTypedoperation(): ?string
    {
        return $this->typedoperation;
    }

    public function setTypedoperation(string $typedoperation): self
    {
        $this->typedoperation = $typedoperation;

        return $this;
    }

    public function getEnvoyeur(): ?Envoyeur
    {
        return $this->envoyeur;
    }

    public function setEnvoyeur(?Envoyeur $envoyeur): self
    {
        $this->envoyeur = $envoyeur;

        return $this;
    }



    public function getNumerotransacion(): ?int
    {
        return $this->numerotransacion;
    }

    public function setNumerotransacion(int $numerotransacion): self
    {
        $this->numerotransacion = $numerotransacion;

        return $this;
    }

    public function getBeneficiaire(): ?Beneficiaire
    {
        return $this->beneficiaire;
    }

    public function setBeneficiaire(?Beneficiaire $beneficiaire): self
    {
        $this->beneficiaire = $beneficiaire;

        return $this;
    }

    public function getCaissier(): ?User
    {
        return $this->caissier;
    }

    public function setCaissier(?User $caissier): self
    {
        $this->caissier = $caissier;

        return $this;
    }
}
