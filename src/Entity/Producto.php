<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="integer")
     */
    private $unidades;

    /**
     * @ORM\Column(type="integer")
     */
    private $precio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tienda", inversedBy="productos")
     */
    private $tienda;

    /**
     * Producto constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUnidades(): ?int
    {
        return $this->unidades;
    }

    public function setUnidades(?int $unidades): self
    {
        $this->unidades = $unidades;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function getPrecioEuros()
    {
        return ($this->precio)/100;
    }

    /**
     * @param $precio
     *
     * @return Producto
     */
    public function setPrecio($precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * @param $precio
     *
     * @throws \Exception
     */
    public function checkAndSetPrecio($precio)
    {
        if (is_numeric($precio))
        {
            $this->setPrecio($precio);
        }
        else {
            throw new \Exception('Error en el precio');
        }
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

    public function getTienda(): ?Tienda
    {
        return $this->tienda;
    }

    public function setTienda(?Tienda $tienda): self
    {
        $this->tienda = $tienda;

        return $this;
    }
}
