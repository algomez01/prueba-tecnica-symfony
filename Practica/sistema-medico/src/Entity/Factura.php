<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $Valor = null;

    #[ORM\Column]
    private ?int $citaId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->Fecha;
    }

    public function setFecha(\DateTimeInterface $Fecha): self
    {
        $this->Fecha = $Fecha;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->Valor;
    }

    public function setValor(string $Valor): self
    {
        $this->Valor = $Valor;

        return $this;
    }

    public function getCitaId(): ?int
    {
        return $this->citaId;
    }

    public function setCitaId(int $citaId): self
    {
        $this->citaId = $citaId;

        return $this;
    }
}
