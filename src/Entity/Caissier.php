<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CaissierRepository;
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
 *      "create_caissier"={
 *              "method"="POST",
 *              "path"="/admin/caissier",
 *              "denormalization_context"={"groups"={"caissier:write"}}
 *       },
 *      "list_caissier"={
 *              "method"="GET",
 *              "path"="/admin/caissiers",
 *              "normalization_context"={"groups"={"caissiers:read"}}
 *       },
 * },
 *      itemOperations={
 *     "showCaissier" = {
 *          "method"= "GET",
 *          "path" = "/admin/caissiers/{id}",
 *          "normalization_context"={"groups"={"Onecaissier:read"}}
 *
 *       },
 *      "archive_caissier" = {
 *          "method"= "DELETE",
 *          "path" = "/admin/caissiers/{id}/archive"
 *
 *       },
 *     }
 * )
 * @ORM\Entity(repositoryClass=CaissierRepository::class)
 */
class Caissier extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"caissiers:read"})
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
