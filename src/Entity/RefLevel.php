<?php

namespace App\Entity;

use App\Repository\RefLevelRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Http\Controller\Reflevel\ChangeStatusAction;

/**
 * @ApiResource(
 *     collectionOperations={
 *       "change-state"={
 *           "method"="PUT",
 *           "path"="/levels/state/{id}",
 *           "openapi_context"={"summary"="change state Level"},
 *           "controller"=ChangeStatusAction::class
 *      },
 *     },
 *     itemOperations={"delete"}
 * )
 * @ORM\Entity(repositoryClass=RefLevelRepository::class)
 */
class RefLevel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
