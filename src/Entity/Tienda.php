<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TiendaRepository")
 */
class Tienda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shopper", mappedBy="tienda")
     */
    private $shoppers;

    public function __construct()
    {
        $this->shoppers = new ArrayCollection();
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

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

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

    /**
     * @return Collection|Shopper[]
     */
    public function getShoppers(): Collection
    {
        return $this->shoppers;
    }

    public function addShopper(Shopper $shopper): self
    {
        if (!$this->shoppers->contains($shopper)) {
            $this->shoppers[] = $shopper;
            $shopper->setTienda($this);
        }

        return $this;
    }

    public function removeShopper(Shopper $shopper): self
    {
        if ($this->shoppers->contains($shopper)) {
            $this->shoppers->removeElement($shopper);
            // set the owning side to null (unless already changed)
            if ($shopper->getTienda() === $this) {
                $shopper->setTienda(null);
            }
        }

        return $this;
    }
}
