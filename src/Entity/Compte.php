<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *       attributes = {
 *
 *              "security" = "is_granted('ROLE_AdminSystem')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "list_compte"={
 *              "method"="GET",
 *              "path"="/admin/comptes",
 *              "normalization_context"={"groups"={"comptes:read"}}
 *       },
 * },
 * itemOperations={
 *      "archive_compte" = {
 *          "method"= "DELETE",
 *          "path" = "/admin/compte/{id}/archive"
 *       },
 *     "showCompte" = {
 *          "method"= "GET",
 *          "path" = "/admin/compte/{id}",
 *          "normalization_context"={"groups"={"Onecomptes:read"}}
 *
 *       },
 *     "charger_compte" = {
 *          "method"= "PUT",
 *          "path" = "/admin/compte/{id}",
 *          "normalization_context"={"groups"={"Onecompte:write"}},
 *          "route_name" = "charger_compte",
 *             "security" = "is_granted('ROLE_AdminSystem') or is_granted('ROLE_Caissier')",
 *             "security_message" = "Accès refusé!"
 *       },
 *     }
 * )
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"userAgence:write" , "comptes:read" , "Onecomptes:read" , "agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userAgence:write" , "comptes:read" , "Onecomptes:read" , "agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"userAgence:write" , "comptes:read" , "Onecomptes:read" , "Onecompte:write" , "OneAgenceTransaction:read"})
     */
    private $solde;

    /**
     * @ORM\Column(type="date")
     * @Groups({"userAgence:write" , "comptes:read" , "Onecomptes:read"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"userAgence:write"})
     */
    private $statut;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, cascade={"persist", "remove"})
     */
    private $agences;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comptes")
     */
    private $caissier;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="compte")
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
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

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAgences(): ?Agence
    {
        return $this->agences;
    }

    public function setAgences(?Agence $agences): self
    {
        $this->agences = $agences;

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
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }
}
