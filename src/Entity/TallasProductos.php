<?php

namespace App\Entity;

use App\Repository\TallasProductosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TallasProductosRepository::class)
 */
class TallasProductos
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
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity=Talla::class, inversedBy="tallasProductos")
     */
    private $talla;

    /**
     * @ORM\ManyToOne(targetEntity=Producto::class, inversedBy="tallasProductos")
     */
    private $producto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getTalla(): ?Talla
    {
        return $this->talla;
    }

    public function setTalla(?Talla $talla): self
    {
        $this->talla = $talla;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }
}
