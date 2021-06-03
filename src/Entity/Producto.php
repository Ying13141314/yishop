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
     * @ORM\OneToMany(targetEntity="ImagenesProducto", mappedBy="producto", cascade={"persist"}, orphanRemoval=true)
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

    /**
     * @ORM\OneToMany(targetEntity=CategoriasProductos::class, mappedBy="producto", orphanRemoval=true)
     */
    private $categorias;

    private $categoriasIds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $xl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $l;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $m;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $s;
    
    
    private $cantidades;

    /**
     * No se guarda en base de datos. Sirve para mostrar luego en el carrito
     * @var int 
     */
    private $total;

    public function __construct()
    {
        $this->imagenes = new ArrayCollection();
        $this->setCreado(new DateTime());
        $this->setActualizado(new DateTime());
        $this->categorias = new ArrayCollection();
    }


    public function calcularTotal()
    {
        $this->total = 0;
        foreach ($this->cantidades as $cantidad) {
            $this->total += ($cantidad * $this->precio);
        }
        
        // Las operaciones son en céntimos. Se divide entre 100 para que en el
        // carrito salga en €
        return $this->total / 100;
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

    /**
     * @return Collection|CategoriasProductos[]
     */
    public function getCategorias(): Collection
    {
        return $this->categorias;
    }

    public function addCategoria(CategoriasProductos $relacion): self
    {
        if (!$this->categorias->contains($relacion)) {
            $this->categorias[] = $relacion;
            $relacion->setProducto($this);
        }

        return $this;
    }

    public function removeCategoria(CategoriasProductos $relacion): self
    {
        if ($this->categorias->removeElement($relacion)) {
            // set the owning side to null (unless already changed)
            if ($relacion->getProducto() === $this) {
                $relacion->setProducto(null);
            }
        }

        return $this;
    }

    /**
     * @param array $categoriasId
     * @return Producto
     */
    public function setCategoriasIds(array $categoriasId)
    {
        $this->categoriasIds = $categoriasId;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategoriasIds(): array
    {
        if (!empty($this->categoriasIds)) {
            return $this->categoriasIds;
        }

        /**
         * @var CategoriasProductos $categoriaRelacion
         */
        $categoriasIds = [];
        foreach ($this->categorias as $categoriaRelacion) {
            $categoriasIds[] =  $categoriaRelacion->getCategoria()->getId();
        }
        return $categoriasIds;
    }

    public function getXl(): ?int
    {
        return $this->xl;
    }

    public function setXl(?int $xl): self
    {
        $this->xl = $xl;

        return $this;
    }

    public function getL(): ?int
    {
        return $this->l;
    }

    public function setL(?int $l): self
    {
        $this->l = $l;

        return $this;
    }

    public function getM(): ?int
    {
        return $this->m;
    }

    public function setM(?int $m): self
    {
        $this->m = $m;

        return $this;
    }

    public function getS(): ?int
    {
        return $this->s;
    }

    public function setS(?int $s): self
    {
        $this->s = $s;

        return $this;
    }
    
    public function getCantidades() {
        return $this->cantidades;
    }

    public function setCantidades($talla, $cantidad)
    {
        $this->cantidades[$talla] = $cantidad;
    }

    /**
     * En base de datos se guarda en céntimos. Hay que dividir para obtener euros 
     * @return int
     */
    public function getTotal() {
        return $this->total / 100;
    }

    /**
     * En base de datos se guarda en céntimos. Hay que dividir para obtener euros
     * @return int
     */
    public function getPrecioEur() {
        return $this->precio / 100;
    }

    public function tieneTalla(): bool
    {
        foreach ($this->categorias as $categoria) {
           if ($categoria->getCategoria()->getConTalla()) {
               return true;
           }
        }
        
        return false;
    }

    public function getCantidadDeTalla(int $talla)
    {
        switch ($talla) {
            case 'xl': return $this->getXl();
            case 'l': return $this->getL();
            case 'm': return $this->getM();
            case 's': return $this->getS();
        }
        
    }
}