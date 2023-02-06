<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cursoId = null;

    #[ORM\Column]
    private ?int $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCursoId(): ?int
    {
        return $this->cursoId;
    }

    public function setCursoId(int $cursoId): self
    {
        $this->cursoId = $cursoId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}