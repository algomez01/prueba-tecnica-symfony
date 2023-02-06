<?php

namespace App\Entity;

use App\Repository\CursosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CursosRepository::class)
 */
class Cursos
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
    private $capacitaciones_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fe_creacion;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacitacionesId(): ?int
    {
        return $this->capacitaciones_id;
    }

    public function setCapacitacionesId(int $capacitaciones_id): self
    {
        $this->capacitaciones_id = $capacitaciones_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getFeCreacion(): ?\DateTimeInterface
    {
        return $this->fe_creacion;
    }

    public function setFeCreacion(\DateTimeInterface $fe_creacion): self
    {
        $this->fe_creacion = $fe_creacion;

        return $this;
    }

}
