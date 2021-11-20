<?php

namespace App\Domain\User\Entity;

use App\Domain\User\Repository\UserPermissionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserPermissionRepository::class)
 */
class UserPermission
{
    const REVOKE=0;
    const GRANT=1;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userPermissions")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Permissions::class, inversedBy="userPermissions")
     */
    private $permission;

    /**
     * @ORM\Column(type="boolean",options={"default":false})
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPermission(): ?Permissions
    {
        return $this->permission;
    }

    public function setPermission(?Permissions $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
