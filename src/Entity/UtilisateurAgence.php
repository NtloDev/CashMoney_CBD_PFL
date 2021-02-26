<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UtilisateurAgenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * attributes = {
 *
 *              "security" = "is_granted('ROLE_AdminSystem') or is_granted('ROLE_AdminAgence')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "create_user_agence"={
 *              "method"="POST",
 *              "path"="/admin/userAgence",
 *              "denormalization_context"={"groups"={"userAgence:write"}}
 *       },
 * },
 *      itemOperations={
 *     "showOneAgenceUser" = {
 *          "method"= "GET",
 *          "path" = "/admin/userAgence/{id}",
 *          "normalization_context"={"groups"={"OneUserAgence:read"}}
 *
 *       },
 *      "archive_user_agence" = {
 *          "method"= "DELETE",
 *          "path" = "/admin/userAgence/{id}/archive"
 *
 *       },
 *     }
 * )
 * @ORM\Entity(repositoryClass=UtilisateurAgenceRepository::class)
 */
class UtilisateurAgence extends User
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
