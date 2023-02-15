<?php

namespace App\Entity;

use App\Repository\CategoriasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriasRepository::class)
 */
class Categorias
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
    private $nombreCategoria;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCategoria(): ?string
    {
        return $this->nombreCategoria;
    }

    public function setNombreCategoria(string $nombreCategoria): self
    {
        $this->nombreCategoria = $nombreCategoria;

        return $this;
    }
}
