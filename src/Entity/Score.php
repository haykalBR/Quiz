<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={"delete"}
 * )
 * @ORM\Entity(repositoryClass=ScoreRepository::class)
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $correctCount;

    /**
     * @ORM\Column(type="integer")
     */
    private $wrongCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorrectCount(): ?int
    {
        return $this->correctCount;
    }

    public function setCorrectCount(int $correctCount): self
    {
        $this->correctCount = $correctCount;

        return $this;
    }

    public function getWrongCount(): ?int
    {
        return $this->wrongCount;
    }

    public function setWrongCount(int $wrongCount): self
    {
        $this->wrongCount = $wrongCount;

        return $this;
    }
}
