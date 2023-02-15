<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriaRepository::class)
 */
class Categoria
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
    private $nomCategoria;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategoria(): ?string
    {
        return $this->nomCategoria;
    }

    public function setNomCategoria(string $nomCategoria): self
    {
        $this->nomCategoria = $nomCategoria;

        return $this;
    }
}
