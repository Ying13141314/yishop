<?php

namespace App\Entity;

use App\Repository\ImagenesProductoRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ImagenesProductoRepository::class)
 *
 * @Vich\Uploadable
 */
class ImagenesProducto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="imagenes")
     * @var Producto
     */
    private $producto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $ruta;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="ruta")
     * @var File|null
     */
    private ?File $imagen = null;

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

    public function __construct() {
        $this->setCreado(new DateTime());
        $this->setActualizado(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImagen(File $imagen = null): void
    {
        if (!$imagen) {
            return;
        }

        $this->imagen = $imagen;
        $this->actualizado = new DateTime();
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    public function setRuta(?string $ruta)
    {
        $this->ruta = $ruta;
        return $this;
    }

    public function getCreado(): ?DateTimeInterface
    {
        return $this->creado;
    }

    public function setCreado(DateTimeInterface $creado): self
    {
        $this->creado = $creado;
        return $this;
    }

    public function getActualizado(): ?DateTimeInterface
    {
        return $this->actualizado;
    }

    public function setActualizado(DateTimeInterface $actualizado): self
    {
        $this->actualizado = $actualizado;
        
        if ($this->producto === null) return $this;
        
        $this->producto->setActualizado($actualizado);

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

    public function eliminarImagen(): void
    {
        unlink(__DIR__ . '/../../public/img/productos/'. $this->ruta);
    }

    public function __toString()
    {
        return $this->ruta;
    }
}
