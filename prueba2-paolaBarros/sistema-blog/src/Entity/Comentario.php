<?php

namespace App\Entity;

use App\Repository\ComentarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComentarioRepository::class)
 */
class Comentario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcioncom;

    /**
     * @ORM\Column(type="integer")
     */
    private $publicacionId;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcioncom(): ?string
    {
        return $this->descripcioncom;
    }

    public function setDescripcioncom(string $descripcioncom): self
    {
        $this->descripcioncom = $descripcioncom;

        return $this;
    }

    public function getPublicacionId(): ?int
    {
        return $this->publicacionId;
    }

    public function setPublicacionId(int $publicacionId): self
    {
        $this->publicacionId = $publicacionId;

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
