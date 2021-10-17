<?php

namespace App\Domain\Category\Entity;

use _PHPStan_0ebfea013\Nette\Utils\DateTime;
use App\Core\Traits\FileUploadTrait;
use App\Core\Traits\SoftDeleteTrait;
use App\Core\Traits\TimestampableTrait;
use App\Domain\Category\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Http\Api\Category\ChangeStatusAction;

/**
 * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={
 *      "delete",
 *      "change-state"={
 *         "method"="PUT",
 *         "path"="/category/state/{id}",
 *         "openapi_context"={"summary"="change state Category"},
 *         "controller"=ChangeStatusAction::class
 *      }
 *
 *    }
 * )
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    use FileUploadTrait, SoftDeleteTrait, TimestampableTrait;
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
     * @ORM\Column(type="boolean")
     */
    private $public;

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

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getUploadDir()
    {
        return 'category';
    }

    public function getNamer()
    {
        $dateTime=new DateTime();
        return uniqid().'-'.$dateTime->format('Y-m-d H:i:s');
    }

    public function getAllowedTypes()
    {
        return ['image/jpeg', 'image/png'];
    }
}
