<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdminAgenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *       attributes = {
 *
 *              "security" = "is_granted('ROLE_AdminSystem')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "create_admin_agence"={
 *              "method"="POST",
 *              "path"="/admin/admin_agence",
 *              "denormalization_context"={"groups"={"adminAgence:write"}}
 *       },
 * },
 * )
 * @ORM\Entity(repositoryClass=AdminAgenceRepository::class)
 */
class AdminAgence extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
