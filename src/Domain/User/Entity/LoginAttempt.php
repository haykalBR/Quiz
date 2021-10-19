<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/10/2021
 * Time: 17:55
 */

namespace App\Domain\User\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Traits\TimestampableTrait;
use App\Domain\User\Repository\LoginAttemptRepository;

/**
 * @ORM\Entity(repositoryClass=LoginAttemptRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class LoginAttempt
{
    use TimestampableTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="loginAttempts")
     */
    private $user;

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
}