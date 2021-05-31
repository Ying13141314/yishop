<?php

namespace App\Entity;

use App\Repository\TallaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TallaRepository::class)
 */
class Talla
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity=TallasProductos::class, mappedBy="talla")
     */
    private $tallasProductos;

    public function __construct()
    {
        $this->tallasProductos = new ArrayCollection();
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

    /**
     * @return Collection|TallasProductos[]
     */
    public function getTallasProductos(): Collection
    {
        return $this->tallasProductos;
    }

    public function addTallasProducto(TallasProductos $tallasProducto): self
    {
        if (!$this->tallasProductos->contains($tallasProducto)) {
            $this->tallasProductos[] = $tallasProducto;
            $tallasProducto->setTalla($this);
        }

        return $this;
    }

    public function removeTallasProducto(TallasProductos $tallasProducto): self
    {
        if ($this->tallasProductos->removeElement($tallasProducto)) {
            // set the owning side to null (unless already changed)
            if ($tallasProducto->getTalla() === $this) {
                $tallasProducto->setTalla(null);
            }
        }

        return $this;
    }
}
