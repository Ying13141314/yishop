<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetallePedido
 *
 * @ORM\Table(name="detalle_pedido", indexes={@ORM\Index(name="FK_detalle_pedido_productos", columns={"idProducto"}), @ORM\Index(name="FK_detalle_pedido_pedidos", columns={"idPedido"})})
 * @ORM\Entity
 */
class DetallePedido
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private int $cantidad;

    /**
     * @var int
     *
     * @ORM\Column(name="precio_unidad", type="integer", nullable=false)
     */
    private int $precioUnidad;

    /**
     * @var Pedido
     *
     * @ORM\ManyToOne(targetEntity="Pedido")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPedido", referencedColumnName="id")
     * })
     */
    private Pedido $pedido;

    /**
     * @var Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProducto", referencedColumnName="id")
     * })
     */
    private Producto $producto;

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

    public function getPrecioUnidad(): ?int
    {
        return $this->precioUnidad;
    }

    public function setPrecioUnidad(int $precioUnidad): self
    {
        $this->precioUnidad = $precioUnidad;

        return $this;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }


}