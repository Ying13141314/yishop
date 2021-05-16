<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="productos", uniqueConstraints={@ORM\UniqueConstraint(name="url", columns={"url"})})
 * @ORM\Entity
 */
class Producto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\OneToMany(targetEntity="ImagenesProducto", mappedBy="producto", cascade={"persist"})
     */
    private $imagenes;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=false)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="precio", type="integer", nullable=false)
     */
    private $precio;

    /**
     * @var int|null
     *
     * @ORM\Column(name="peso", type="integer", nullable=true)
     */
    private $peso;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false, options={"default"="1"})
     */
    private $activo = true;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var DateTimeInterface
     */
    private DateTimeInterface $creado;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var DateTimeInterface
     */
    private DateTimeInterface $actualizado;
    

    public function __construct()
    {
        $this->imagenes = new ArrayCollection();
        $this->setCreado(new DateTime());
        $this->setActualizado(new DateTime());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio(int $precio)
    {
        $this->precio = $precio;

        return $this;
    }

    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso(?int $peso)
    {
        $this->peso = $peso;

        return $this;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function setActivo(bool $activo)
    {
        $this->activo = $activo;

        return $this;
    }

    public function getCreado()
    {
        return $this->creado;
    }

    public function setCreado($creado)
    {
        $this->creado = $creado;

        return $this;
    }

    public function getActualizado()
    {
        return $this->actualizado;
    }

    public function setActualizado($actualizado): self
    {
        $this->actualizado = $actualizado;

        return $this;
    }

    /**
     * @return Collection|ImagenesProducto[]
     */
    public function getImagenes(): Collection
    {
        return $this->imagenes;
    }

    public function addImagene(ImagenesProducto $imagene): self
    {
        if (!$this->imagenes->contains($imagene)) {
            $this->imagenes[] = $imagene;
            $imagene->setProducto($this);
        }

        return $this;
    }

    public function removeImagene(ImagenesProducto $imagen): self
    {
        if ($this->imagenes->removeElement($imagen)) {
            // set the owning side to null (unless already changed)
            if ($imagen->getProducto() === $this) {
                $imagen->setProducto(null);
                $imagen->eliminarImagen();
            }
        }

        return $this;
    }
}