<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $nombre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $con_talla;

    /**
     * @ORM\Column(type="boolean")
     */
    private $principal;

    /**
     * @ORM\OneToMany(targetEntity=CategoriasProductos::class, mappedBy="categoria")
     */
    private $relacion;
    
    public function __construct()
    {
        $this->relacion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getConTalla(): ?bool
    {
        return $this->con_talla;
    }

    public function setConTalla(bool $con_talla): self
    {
        $this->con_talla = $con_talla;

        return $this;
    }

    public function getPrincipal(): ?bool
    {
        return $this->principal;
    }

    public function setPrincipal(bool $principal): self
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * @return Collection|CategoriasProductos[]
     */
    public function getRelacion(): Collection
    {
        return $this->relacion;
    }

    public function addRelacion(CategoriasProductos $relacion): self
    {
        if (!$this->relacion->contains($relacion)) {
            $this->relacion[] = $relacion;
            $relacion->setCategoria($this);
        }

        return $this;
    }

    public function removeRelacion(CategoriasProductos $relacion): self
    {
        if ($this->relacion->removeElement($relacion)) {
            // set the owning side to null (unless already changed)
            if ($relacion->getCategoria() === $this) {
                $relacion->setCategoria(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nombre;
    }
}
