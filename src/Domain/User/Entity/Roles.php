<?php

namespace App\Domain\User\Entity;

use App\Core\Traits\TimestampableTrait;
use App\Domain\Roles\Repository\Domain\User\Entity\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;

/**
 * @ORM\Entity(repositoryClass=RolesRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Roles implements RoleInterface
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
     * @ORM\Column(type="string", length=100)
     */
    private $guardName;
    /**
     * @ORM\ManyToMany(targetEntity=Permissions::class, mappedBy="roles")
     */
    private $permissions;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="role")
     */
    private $users;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
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
     * @return Collection|Permissions[]
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permissions $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->addRole($this);
        }

        return $this;
    }

    public function removePermission(Permissions $permission): self
    {
        if ($this->permissions->removeElement($permission)) {
            $permission->removeRole($this);
        }

        return $this;
    }

    public function hasPermission($permission)
    {
        return $this->getPermissions()->exists(function($key, $value) use ($permission){
            return $value->getGuardName() === $permission;
        });
    }

    public function isSuperAdmin()
    {
        return $this->getGuardName() === static::ROLE_SUPER_ADMIN;
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
            $user->addRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeRole($this);
        }

        return $this;
    }
}
