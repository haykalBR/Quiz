<?php

namespace App\Domain\Media\Entity;

use App\Core\Traits\FileUploadTrait;
use App\Domain\Media\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    use FileUploadTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUploadDir()
    {
        // TODO: Implement getUploadDir() method.
    }

    public function getNamer()
    {
        // TODO: Implement getNamer() method.
    }

    public function getAllowedTypes()
    {
        return [];
    }
}
