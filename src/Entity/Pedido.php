<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pedido
 *
 * @ORM\Table(name="pedidos", indexes={@ORM\Index(name="FK_pedidos_clientes", columns={"idCliente"})})
 * @ORM\Entity
 */
class Pedido
{
    public const ENVIADO = "enviado";
    public const RECIBIDO = "recibido";
    public const EN_PROCESO = "en proceso";
    public const CANCELADO = "cancelado";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=0, nullable=false)
     */
    private string $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=200, nullable=false)
     */
    private string $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_postal", type="string", length=10, nullable=false)
     */
    private string $codigoPostal;

    /**
     * @var Cliente|null
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCliente", referencedColumnName="id")
     * })
     */
    private $cliente;
    
    private $idCliente;

    public function __construct() {
        $this->setFecha(new DateTime());
    }

    /**
     * @return mixed
     */
    public function getIdCliente()
    {
        if ($this->cliente != null) {
            return $this->cliente->getId();
        }
        return null;
    }

    public function getIdClienteRaw()
    {
        return $this->idCliente;
    }

    /**
     * @param mixed $idCliente
     */
    public function setIdCliente($idCliente): void
    {
        $this->idCliente = $idCliente;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente($cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }


}