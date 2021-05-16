<?php

namespace App\Entity;

use App\Repository\CategoriasProductosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriasProductosRepository::class)
 */
class CategoriasProductos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Producto::class, inversedBy="idCategoria")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProducto;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class, inversedBy="idProducto")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCategoria;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProducto(): ?Producto
    {
        return $this->idProducto;
    }

    public function setIdProducto(?Producto $idProducto): self
    {
        $this->idProducto = $idProducto;

        return $this;
    }

    public function getIdCategoria(): ?Categoria
    {
        return $this->idCategoria;
    }

    public function setIdCategoria(?Categoria $idCategoria): self
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }
}
