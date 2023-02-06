<?php

namespace App\Entity;

use App\Repository\CursoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursoRepository::class)]
class Curso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NombreCurso = null;

    #[ORM\Column]
    private ?bool $Estado = null;

    #[ORM\Column]
    private ?int $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCurso(): ?string
    {
        return $this->NombreCurso;
    }

    public function setNombreCurso(string $NombreCurso): self
    {
        $this->NombreCurso = $NombreCurso;

        return $this;
    }

    public function isEstado(): ?bool
    {
        return $this->Estado;
    }

    public function setEstado(bool $Estado): self
    {
        $this->Estado = $Estado;

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
