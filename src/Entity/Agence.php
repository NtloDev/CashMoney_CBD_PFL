<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AgenceRepository;
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
 *              "security" = "is_granted('ROLE_AdminAgence')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "create_caissier"={
 *              "method"="POST",
 *              "path"="/admin/caissier",
 *              "denormalization_context"={"groups"={"caissier:write"}}
 *       },
 *      "list_agence"={
 *              "method"="GET",
 *              "path"="/admin/agence",
 *              "normalization_context"={"groups"={"agence:read"}}
 *       },
 *     "list_agence_transactions"={
 *              "method"="GET",
 *              "path"="/admin/agenceTransactions",
 *              "normalization_context"={"groups"={"agenceTransactions:read"}},
 *              "security" = "is_granted('ROLE_AdminSystem')",
 *               "security_message" = "Accès refusé!"
 *       },
 * },
 *     itemOperations={
 *     "showAgenceTransaction" = {
 *          "method"= "GET",
 *          "path" = "/admin/agenceTransaction/{id}",
 *          "normalization_context"={"groups"={"OneAgenceTransaction:read"}},
 *          "security" = "is_granted('ROLE_AdminAgence')",
 *               "security_message" = "Accès refusé!"
 *
 *       },
 *      "archive_caissier" = {
 *          "method"= "DELETE",
 *          "path" = "/admin/agence/{id}/archive"
 *
 *       },
 *     }
 * )
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"userAgence:write" , "agence:read" ,"agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userAgence:write" , "agence:read" , "agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"userAgence:write" , "agence:read" , "OneAgenceTransaction:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userAgence:write" , "agence:read" , "agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $adress;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"userAgence:write" , "agence:read"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"userAgence:write" , "agence:read"})
     */
    private $lattitude;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agence")
     * @Groups ({"agence:read"})
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Compte::class, cascade={"persist", "remove"})
     * @Groups({"userAgence:write" , "agenceTransactions:read" , "OneAgenceTransaction:read"})
     */
    private $compte;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLattitude(): ?float
    {
        return $this->lattitude;
    }

    public function setLattitude(?float $lattitude): self
    {
        $this->lattitude = $lattitude;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAgence($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgence() === $this) {
                $user->setAgence(null);
            }
        }

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
}
