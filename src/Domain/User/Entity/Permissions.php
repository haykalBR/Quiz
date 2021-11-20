<?php

namespace App\Domain\User\Entity;

use App\Core\Traits\TimestampableTrait;
use App\Domain\User\Repository\PermissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Http\Api\Permissions\CreateNewGuardAction;
use ApiPlatform\Core\Annotation\ApiResource;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;

/**
 * @ApiResource(
 *  collectionOperations={
 *       "add-guard-route"={
 *       "method"="POST",
 *       "path"="/permissions/add-guard-route",
 *       "openapi_context"={"summary"="add  new  guard route "},
 *       "controller"=CreateNewGuardAction::class,
 *      "denormalization_context"={"groups"={"write:newpermission"}}
 *      }
 *     },
 *  itemOperations={}
 * )
 * @ORM\Entity(repositoryClass=PermissionsRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Permissions
{
    use TimestampableTrait, SoftDeleteable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Roles::class, inversedBy="permissions")
     */
    private $roles;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $guardName;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="permissions")
     */
    private $users;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getGuardName(): ?string
    {
        return $this->guardName;
    }

    public function setGuardName(string $guardName): self
    {
        $this->guardName = $guardName;

        return $this;
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
     * @return Collection|Roles[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Roles $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Roles $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
