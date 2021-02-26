<?php

namespace App\Entity;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function array_unique;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 * attributes = {
 *
 *              "security" = "is_granted('ROLE_AdminSystem')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *     "getUsers" = {
 *              "method"= "GET",
 *              "path" = "/admin/users",
 *              "normalization_context"={"groups"={"users:read"}}
 *       },
 * },
 * itemOperations={
 *      "getUserById"={
 *          "method"= "GET",
 *          "path"= "/admin/users/{id}",
 *          "normalization_context"={"groups"={"OneUser:read"}}
 *      },
 *      "archive_user" = {
 *          "method"= "DELETE",
 *          "path" = "/admin/users/{id}/archive"
 *
 *       },"putUserId"={
 *              "method"="PUT",
 *              "path"="api/admin/users/{id}",
 *              "deserialize"=false
 *       },
 * }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="dtype", type="string")
 * @DiscriminatorMap({"AdminAgence" = "AdminAgence", "AdminSystem" = "AdminSystem","User"="User","Caissier"="Caissier","UtilisateurAgence"="UtilisateurAgence"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"userAgence:write" , "caissier:write" , "adminAgence:write" , "adminSystem:write" , "Onecaissier:read" , "agence:read"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"userAgence:write" , "caissier:write" , "adminAgence:write" , "adminSystem:write" , "Onecaissier:read"})
     */
    private $username;

    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     * @Groups({"userAgence:write" , "caissier:write" , "adminAgence:write" , "adminSystem:write" , "caissiers:read" , "Onecaissier:read" , "agence:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userAgence:write" , "caissier:write" , "adminAgence:write" , "adminSystem:write" , "caissiers:read" , "Onecaissier:read" , "agence:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userAgence:write" , "caissier:write" , "adminAgence:write" , "adminSystem:write" , "caissiers:read" , "Onecaissier:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"userAgence:write" , "caissier:write" , "adminAgence:write" , "adminSystem:write" , "caissiers:read" , "Onecaissier:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"userAgence:write" , "caissier:write" , "adminAgence:write" , "adminSystem:write" , "Onecaissier:read"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users" , cascade="persist")
     * @Groups({"userAgence:write" , "caissier:write" , "adminAgence:write" , "adminSystem:write" , "Onecaissier:read"})
     */
    private $profil;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="users" , cascade="persist")
     * @Groups({"userAgence:write"})
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Compte::class, mappedBy="caissier" , cascade="persist")
     */
    private $comptes;

    /**
     * @Groups({"userAgence:write" ,  "caissier:write" , "adminAgence:write" , "adminSystem:write"})
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="user")
     */
    private $transactions;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    public function setPassword(string $password): self
    {

        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setCaissier($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getCaissier() === $this) {
                $compte->setCaissier(null);
            }
        }

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

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
            $transaction->setUser($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUser() === $this) {
                $transaction->setUser(null);
            }
        }

        return $this;
    }
}
