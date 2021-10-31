<?php

namespace App\Domain\Categories\Entity;

use App\Core\Traits\FileUploadTrait;
use App\Core\Traits\SoftDeleteTrait;
use App\Core\Traits\TimestampableTrait;
use App\Domain\Categories\Repository\TechnologyRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=TechnologyRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Technology
{
    use FileUploadTrait,TimestampableTrait,SoftDeleteTrait;
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
}
