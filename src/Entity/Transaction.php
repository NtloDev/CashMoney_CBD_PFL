<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *       attributes = {
 *
 *              "security" = "is_granted('ROLE_UtilisateurAgence') or is_granted('ROLE_AdminAgence')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "create_transaction"={
 *              "method"="POST",
 *              "path"="/admin/transaction",
 *              "route_name" = "create_transaction",
 *
 *       },
 * },
 * itemOperations={
 *     "showTransaction" = {
 *          "method"= "GET",
 *          "path" = "/admin/transaction/{id}",
 *          "normalization_context"={"groups"={"OneTransaction:read"}}
 *
 *       },
 *     "transaction_retrait" = {
 *          "method"= "PUT",
 *          "path" = "/admin/transaction/{id}",
 *          "route_name" = "transaction_retrait",
 *             "security" = "is_granted('ROLE_AdminAgence') or is_granted('ROLE_UtilisateurAgence')",
 *             "security_message" = "Accès refusé!"
 *       },
 *     }
 * )
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"OneTransaction:read" , "agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $frais;

    /**
     * @ORM\Column(type="integer")
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="integer")
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $fraisSystem;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="transactions")
     */
    private $compte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $depot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $retrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EmeteurNomComplet;

    /**
     * @ORM\Column(type="integer")
     */
    private $emmeteurTelephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $beneficiaireNomComplet;

    /**
     * @ORM\Column(type="integer")
     */
    private $beneficiaireTelephone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emmeteurCNI;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $beneficiaireCNI;

    /**
     * @ORM\Column(type="integer")
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $fraisOperateurDepot;

    /**
     * @ORM\Column(type="integer")
     * @Groups ({"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $fraisOperateurRetrait;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
    public function getFraisEtat(): ?int
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(int $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getFraisSystem(): ?int
    {
        return $this->fraisSystem;
    }

    public function setFraisSystem(int $fraisSystem): self
    {
        $this->fraisSystem = $fraisSystem;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getDepot(): ?bool
    {
        return $this->depot;
    }

    public function setDepot(bool $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    public function getRetrait(): ?bool
    {
        return $this->retrait;
    }

    public function setRetrait(bool $retrait): self
    {
        $this->retrait = $retrait;

        return $this;
    }

    public function getEmeteurNomComplet(): ?string
    {
        return $this->EmeteurNomComplet;
    }

    public function setEmeteurNomComplet(string $EmeteurNomComplet): self
    {
        $this->EmeteurNomComplet = $EmeteurNomComplet;

        return $this;
    }

    public function getEmmeteurTelephone(): ?int
    {
        return $this->emmeteurTelephone;
    }

    public function setEmmeteurTelephone(int $emmeteurTelephone): self
    {
        $this->emmeteurTelephone = $emmeteurTelephone;

        return $this;
    }

    public function getBeneficiaireNomComplet(): ?string
    {
        return $this->beneficiaireNomComplet;
    }

    public function setBeneficiaireNomComplet(string $beneficiaireNomComplet): self
    {
        $this->beneficiaireNomComplet = $beneficiaireNomComplet;

        return $this;
    }

    public function getBeneficiaireTelephone(): ?int
    {
        return $this->beneficiaireTelephone;
    }

    public function setBeneficiaireTelephone(int $beneficiaireTelephone): self
    {
        $this->beneficiaireTelephone = $beneficiaireTelephone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEmmeteurCNI(): ?string
    {
        return $this->emmeteurCNI;
    }

    public function setEmmeteurCNI(string $emmeteurCNI): self
    {
        $this->emmeteurCNI = $emmeteurCNI;

        return $this;
    }

    public function getBeneficiaireCNI(): ?string
    {
        return $this->beneficiaireCNI;
    }

    public function setBeneficiaireCNI(string $beneficiaireCNI): self
    {
        $this->beneficiaireCNI = $beneficiaireCNI;

        return $this;
    }

    public function getFraisOperateurDepot(): ?int
    {
        return $this->fraisOperateurDepot;
    }

    public function setFraisOperateurDepot(int $fraisOperateurDepot): self
    {
        $this->fraisOperateurDepot = $fraisOperateurDepot;

        return $this;
    }

    public function getFraisOperateurRetrait(): ?int
    {
        return $this->fraisOperateurRetrait;
    }

    public function setFraisOperateurRetrait(int $fraisOperateurRetrait): self
    {
        $this->fraisOperateurRetrait = $fraisOperateurRetrait;

        return $this;
    }
}
