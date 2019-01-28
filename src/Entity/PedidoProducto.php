<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoProductoRepository")
 */
class PedidoProducto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pedido")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id",nullable=false)
     */
    private $pedido;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id",nullable=false)
     */
    private $producto;

    /**
     * @ORM\Column(type="integer")
     */
    private $unidades;

    /**
     * PedidoProducto constructor.
     *
     * @param Producto $producto
     * @param Pedido   $pedido
     */
    public function __construct(Producto $producto, Pedido $pedido)
    {
        $this->producto = $producto;
        $this->pedido = $pedido;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * @param mixed $pedido
     */
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * @return mixed
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param mixed $producto
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    public function getUnidades(): ?int
    {
        return $this->unidades;
    }

    public function setUnidades(int $unidades): self
    {
        $this->unidades = $unidades;

        return $this;
    }
}
