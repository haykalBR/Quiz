<?php

namespace App\Domain\User\Entity;

use App\Domain\User\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Http\Api\Users\GetPermissionFromRolesAction;
/**
 * @ApiResource(
 *     collectionOperations={
 *   "permission-from-roles"={
 *       "method"="post",
 *       "path"="/users/permission-from-roles",
 *       "openapi_context"={"summary"=" Get  permission  from  roles "},
 *       "controller"=GetPermissionFromRolesAction::class,
 *       "normalization_context"={"groups"={"read:permission:roles"}},
 *       "denormalization_context"={"groups"={"read:permission:roles"}},
 *      }
 *     },
 *     itemOperations={
 *     "delete"
 *     }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User extends UserAbstract implements PasswordAuthenticatedUserInterface, TwoFactorInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $authCode;
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @ORM\Column(type="boolean",options={"default":true})
     */
    private bool $enabled;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;
    /**
     * @ORM\ManyToMany(targetEntity=Roles::class, inversedBy="users")
     */
    private $role;
    /**
     * @ORM\OneToMany(targetEntity=UserPermission::class, mappedBy="user")
     */
    private $userPermissions;
    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="users")
     */
    private $groupes;
    private $grantPermission;
    private $revokePermission;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="users")
     */
    private $userClone;
    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="userClone")
     */
    private $users;
    public function __construct()
    {
        $this->role = new ArrayCollection();
        $this->userPermissions = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->users = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function isEmailAuthEnabled(): bool
    {
        return true; // This can be a persisted field to switch email code authentication on/off
    }
    public function getEmailAuthRecipient(): string
    {
        return $this->email;
    }
    public function getEmailAuthCode(): string
    {
        if (null === $this->authCode) {
            throw new LogicException('The email authentication code was not set');
        }

        return $this->authCode;
    }
    public function setEmailAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
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
    /**
     * @return Collection|Roles[]
     */
    public function getRole(): Collection
    {
        return $this->role;
    }
    public function addRole(Roles $role): self
    {
        if (!$this->role->contains($role)) {
            $this->role[] = $role;
        }

        return $this;
    }
    public function removeRole(Roles $role): self
    {
        $this->role->removeElement($role);

        return $this;
    }
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }
    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }
    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }
    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }
    /**
     * @return mixed
     */
    public function getGrantPermission()
    {
        return $this->grantPermission;
    }
    /**
     * @param mixed $grantPermission
     */
    public function setGrantPermission($grantPermission): void
    {
        $this->grantPermission = $grantPermission;
    }
    /**
     * @return mixed
     */
    public function getRevokePermission()
    {
        return $this->revokePermission;
    }
    /**
     * @param mixed $revokePermission
     */
    public function setRevokePermission($revokePermission): void
    {
        $this->revokePermission = $revokePermission;
    }
    /**
     * @return Collection|UserPermission[]
     */
    public function getUserPermissions(): Collection
    {
        return $this->userPermissions;
    }
    public function addUserPermission(UserPermission $userPermission): self
    {
        if (!$this->userPermissions->contains($userPermission)) {
            $this->userPermissions[] = $userPermission;
            $userPermission->setUser($this);
        }

        return $this;
    }
    public function removeUserPermission(UserPermission $userPermission): self
    {
        if ($this->userPermissions->removeElement($userPermission)) {
            // set the owning side to null (unless already changed)
            if ($userPermission->getUser() === $this) {
                $userPermission->setUser(null);
            }
        }

        return $this;
    }
    /**
     * verfiy has permission in role
     * @param array $roles
     * @param string $permissionName
     * @return bool
     */
    public function hasRoles( $roles, $permissionName){
        foreach ($roles as $role) {
            if ($role->hasPermission($permissionName)) {
                return true;
            }
        }
        return false;
    }
    public function hasPermission( $permissionName): bool
    {
        $hasPermission = false;
        $collectionPermissions    = collect($this->getUserPermissions()->toArray());
        $collectionGroupes    = collect($this->getGroupes()->toArray());
        if ($collectionGroupes->count()>0){
            foreach ($collectionGroupes as $groupe){
                $hasPermission = $this->hasRoles($groupe->getRoles(),$permissionName);
            }
        }
        /**
         * verfication with roles
         */
        $hasPermission = $this->hasRoles($this->getRole(),$permissionName);
        /**
         * verfication with UserPermissions
         */
        /*
         * if user has custom permission
         */
        if ($collectionPermissions->count() > 0) {
            $grantPermission = $collectionPermissions->filter(function ($item) {
                return UserPermission::GRANT == $item->getStatus();
            });
            /*
             * if user has grant permission
             */
            if ($grantPermission->count() > 0) {
                $grantPermissionArrayCollection=new ArrayCollection($grantPermission->toArray());
                $isGrantPermission             = $grantPermissionArrayCollection->map(function ($value) use ($permissionName,$hasPermission) {
                    if ($value->hasPermission($permissionName)) {
                        return $value;
                    }
                });
                if (null !== $isGrantPermission->current()) {
                    $hasPermission=true;
                }
            }
            $revokePermission = $collectionPermissions->filter(function ($item) {
                return UserPermission::REVOKE == $item->getStatus();
            });

            /*
             * if user has revoke permission
             */
            if ($revokePermission->count() > 0) {
                $grantPermissionArrayCollection=new ArrayCollection($revokePermission->toArray());
                $isRevokePermission            = $grantPermissionArrayCollection->map(function ($value) use ($permissionName,$hasPermission) {
                    if ($value->hasPermission($permissionName)) {
                        return $value;
                    }
                });
                if (null !== $isRevokePermission->current()) {
                    $hasPermission=false;
                }
            }
        }
        return $hasPermission;
    }
    public function isSuperAdmin()
    {
        $isSuperAdmin = false;
        foreach ($this->getRole() as $role) {
            if ($role->isSuperAdmin()) {
                return true;
            }
        }

        return $isSuperAdmin;
    }
    public function hasRole(RoleInterface $role)
    {
        return $this->getRole()->contains($role);
    }
    /**
     * @return mixed
     */
    public function getSuperAdmin()
    {
        return $this->superAdmin;
    }
    /**
     * @param mixed $superAdmin
     */
    public function setSuperAdmin($superAdmin): void
    {
        $this->superAdmin = $superAdmin;
    }
    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }
    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
        }

        return $this;
    }
    public function removeGroupe(Groupe $groupe): self
    {
        $this->groupes->removeElement($groupe);

        return $this;
    }

    public function getUserClone(): ?self
    {
        return $this->userClone;
    }

    public function setUserClone(?self $userClone): self
    {
        $this->userClone = $userClone;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setUserClone($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUserClone() === $this) {
                $user->setUserClone(null);
            }
        }

        return $this;
    }


}
