<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Citasid = null;

    #[ORM\Column]
    private ?int $valor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCitasid(): ?int
    {
        return $this->Citasid;
    }

    public function setCitasid(int $Citasid): self
    {
        $this->Citasid = $Citasid;

        return $this;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): self
    {
        $this->valor = $valor;

        return $this;
    }
}
