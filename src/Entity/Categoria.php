<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
#[UniqueEntity(['nombre'], message: 'El nombre tiene que ser único')]
#[UniqueEntity(['orden'], message: 'Ya hay una categoría con ese número de orden')]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'El campo nombre es obligatorio')]
    private ?string $nombre = null;

    #[ORM\Column(unique: true)]
    #[Assert\Positive(message: 'El número de orden tiene que ser positivo')]
    #[Assert\NotBlank(message: 'El campo orden es obligatorio')]
    private ?int $orden = null;

    /**
     * @var Collection<int, Carta>
     */
    #[ORM\OneToMany(targetEntity: Carta::class, mappedBy: 'categoria')]
    private Collection $cartaItems;

    public function __construct()
    {
        $this->cartaItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setOrden(int $orden): static
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * @return Collection<int, Carta>
     */
    public function getCartaItems(): Collection
    {
        return $this->cartaItems;
    }

    public function addCartaItem(Carta $cartaItem): static
    {
        if (!$this->cartaItems->contains($cartaItem)) {
            $this->cartaItems->add($cartaItem);
            $cartaItem->setCategoria($this);
        }

        return $this;
    }

    public function removeCartaItem(Carta $cartaItem): static
    {
        if ($this->cartaItems->removeElement($cartaItem)) {
            // set the owning side to null (unless already changed)
            if ($cartaItem->getCategoria() === $this) {
                $cartaItem->setCategoria(null);
            }
        }

        return $this;
    }
}
