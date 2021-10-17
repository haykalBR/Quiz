<?php

namespace App\Core\Traits;

trait SoftDeleteTrait
{
    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}