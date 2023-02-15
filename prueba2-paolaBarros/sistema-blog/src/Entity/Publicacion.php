<?php

namespace App\Entity;

use App\Repository\PublicacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicacionRepository::class)
 */
class Publicacion
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
    private $Titulo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    

    /**
     * @ORM\Column(type="integer")
     */
    private $categoriaId;

    /**
     * @ORM\Column(type="integer")
     */
    private $trabajadorId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;
    const ESTADO_TRUE = 'ESTADO_TRUE';
    const ESTADO_FALSE = 'ESTADO_FALSE';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->Titulo;
    }

    public function setTitulo(string $Titulo): self
    {
        $this->Titulo = $Titulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    

    public function getCategoriaId(): ?int
    {
        return $this->categoriaId;
    }

    public function setCategoriaId(int $categoriaId): self
    {
        $this->categoriaId = $categoriaId;

        return $this;
    }

    public function getTrabajadorId(): ?int
    {
        return $this->trabajadorId;
    }

    public function setTrabajadorId(int $trabajadorId): self
    {
        $this->trabajadorId = $trabajadorId;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
