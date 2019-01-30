<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoRepository")
 */
class Pedido
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clienteNombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clienteEmail;

    /**
     * @ORM\Column(type="integer")
     */
    private $clienteTelefono;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clienteDireccion;

    /**
     * @ORM\Column(type="integer")
     */
    private $importe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaEntrega;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PedidoProducto", mappedBy="Pedido", cascade={"persist", "remove"})
     */
    private $pedidoProductos;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $franjaHoraria;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->pedidoProductos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClienteNombre(): ?string
    {
        return $this->clienteNombre;
    }

    public function setClienteNombre(string $clienteNombre): self
    {
        $this->clienteNombre = $clienteNombre;

        return $this;
    }

    public function getClienteEmail(): ?string
    {
        return $this->clienteEmail;
    }

    public function setClienteEmail(string $clienteEmail): self
    {
        $this->clienteEmail = $clienteEmail;

        return $this;
    }

    public function getClienteTelefono(): ?int
    {
        return $this->clienteTelefono;
    }

    public function setClienteTelefono(int $clienteTelefono): self
    {
        $this->clienteTelefono = $clienteTelefono;

        return $this;
    }

    public function getClienteDireccion(): ?string
    {
        return $this->clienteDireccion;
    }

    public function setClienteDireccion(string $clienteDireccion): self
    {
        $this->clienteDireccion = $clienteDireccion;

        return $this;
    }

    public function getImporte(): ?int
    {
        return $this->importe;
    }

    public function setImporte(int $importe): self
    {
        $this->importe = $importe;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFechaEntrega(): ?\DateTimeInterface
    {
        return $this->fechaEntrega;
    }

    public function setFechaEntrega($fechaEntrega): self
    {
        $this->fechaEntrega = $fechaEntrega;

        return $this;
    }

    /**
     * @return Collection|PedidoProducto[]
     */
    public function getPedidoProductos(): Collection
    {
        return $this->pedidoProductos;
    }

    public function addPedidoProducto(PedidoProducto $pedidoProducto): self
    {
        if (!$this->pedidoProductos->contains($pedidoProducto)) {
            $this->pedidoProductos[] = $pedidoProducto;
            $pedidoProducto->setPedido($this);
        }

        return $this;
    }

    public function removePedidoProducto(PedidoProducto $pedidoProducto): self
    {
        if ($this->pedidoProductos->contains($pedidoProducto)) {
            $this->pedidoProductos->removeElement($pedidoProducto);
//            $pedidoProducto->removePedido($this);
        }

        return $this;
    }

    public function getFranjaHoraria(): ?string
    {
        return $this->franjaHoraria;
    }

    public function setFranjaHoraria(?string $franjaHoraria): self
    {
        $this->franjaHoraria = $franjaHoraria;

        return $this;
    }
}
