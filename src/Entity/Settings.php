<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
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
    private $theKey;

    /**
     * @ORM\Column(type="text")
     */
    private $theValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheKey(): ?string
    {
        return $this->theKey;
    }

    public function setTheKey(string $theKey): self
    {
        $this->theKey = $theKey;

        return $this;
    }

    public function getTheValue(): ?string
    {
        return $this->theValue;
    }

    public function setTheValue(string $theValue): self
    {
        $this->theValue = $theValue;

        return $this;
    }
}
