<?php

namespace App\Domain\User\Entity;
use App\Domain\User\Repository\RefLevelRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Http\Api\Reflevel\ChangeStatusAction;

/**
 * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={
 *     "delete",
 *     "change-state"={
 *         "method"="PUT",
 *         "path"="/levels/state/{id}",
 *         "openapi_context"={"summary"="change state Level"},
 *         "controller"=ChangeStatusAction::class
 *      }
 *     }
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
    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }
}
