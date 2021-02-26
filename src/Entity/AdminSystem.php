<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdminSystemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *       attributes = {
 *
 *              "security" = "is_granted('ROLE_AdminSystem')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "create_admin_system"={
 *              "method"="POST",
 *              "path"="/admin/admin_system",
 *              "denormalization_context"={"groups"={"adminSystem:write"}}
 *       },
 * },
 * )
 * @ORM\Entity(repositoryClass=AdminSystemRepository::class)
 */
class AdminSystem extends User
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
