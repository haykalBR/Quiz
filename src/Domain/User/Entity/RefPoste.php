<?php

namespace App\Domain\User\Entity;

use App\Domain\User\Repository\RefPosteRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Http\Api\RefPoste\ChangeStatusAction;

/**
 * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={
 *     "delete",
 *     "change-state"={
 *         "method"="PUT",
 *         "path"="/poste/state/{id}",
 *         "openapi_context"={"summary"="change state poste"},
 *         "controller"=ChangeStatusAction::class
 *      }
 *     }
 * )
 * @ORM\Entity(repositoryClass=RefPosteRepository::class)
 */
class RefPoste
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
    /**
     * @ORM\Column(type="boolean",options={"default":true})
     */
    private bool  $enabled;

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

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

}
