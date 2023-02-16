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
    private $nomCategorias;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNomCategorias(): ?string
    {
        return $this->nomCategorias;
    }

    public function setNomCategorias(string $nomCategorias): self
    {
        $this->nomCategorias = $nomCategorias;

        return $this;
    }
}
