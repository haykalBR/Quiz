<?php

namespace App\Domain\Categories\Entity;

use App\Core\Traits\FileUploadTrait;
use App\Core\Traits\SoftDeleteTrait;
use App\Core\Traits\TimestampableTrait;
use App\Domain\Categories\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Http\Api\Categories\ChangeStatusAction;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={
 *      "delete",
 *      "change-state"={
 *         "method"="PUT",
 *         "path"="/Categories/state/{id}",
 *         "openapi_context"={"summary"="change state Categories"},
 *         "controller"=ChangeStatusAction::class
 *      }
 *
 *    }
 * )
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Categories
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
    /**
     * @Gedmo\Slug(fields={"name"},separator="_")
     * @ORM\Column(type="string", length=255,unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="categories")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Categories::class, mappedBy="parent")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Technology::class, mappedBy="categories")
     */
    private $technologies;

    public function __toString(): string
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->technologies = new ArrayCollection();
    }

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
        $dateTime=new \DateTime();
        return uniqid().'-'.$dateTime->format('Y-m-d H:i:s');
    }

    public function getAllowedTypes()
    {
        return ['image/jpeg', 'image/png'];
    }
    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setParent($this);
        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            if ($category->getParent() === $this) {
                $category->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Technology[]
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
            $technology->addCategory($this);
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        if ($this->technologies->removeElement($technology)) {
            $technology->removeCategory($this);
        }

        return $this;
    }
}
