<?php
namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ReservaRepository::class)]
class Reserva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan(
        value: "today",
        message: "La reserva debe realizarse con al menos un día de antelación"
    )]
    private ?\DateTime $fecha = null;

    #[ORM\Column(type : Types::TIME_MUTABLE)]
    private ?\DateTime $hora = null;

    #[Assert\Callback]
    public function validateHora(ExecutionContextInterface $context)
    {
        if (null === $this->hora) {
            return;
        }

        $h = $this->hora->format("H:i");

        $comidaInicio = '14:00';
        $comidaFin    = "16:00";
        $cenaInicio   = "20:00";
        $cenaFin      = "22:00";

        $horaValidaComida = ($h >= $comidaInicio && $h <= $comidaFin);
        $horaCenaValida   = ($h >= $cenaInicio && $h <= $cenaFin);

        if (! $horaValidaComida && ! $horaCenaValida) {
            $context->buildViolation('Solo aceptamos reservas de 14:00 a 16:00 y de 20:00 a 22:00')
                ->atPath('hora')
                ->addViolation();
        }
    }

    #[ORM\ManyToOne(inversedBy : 'reservas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?int $comensales = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $confirmada = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTime
    {
        return $this->hora;
    }

    public function setHora(\DateTime $hora): static
    {
        $this->hora = $hora;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getComensales(): ?int
    {
        return $this->comensales;
    }

    public function setComensales(int $comensales): static
    {
        $this->comensales = $comensales;

        return $this;
    }

    public function isConfirmada(): bool
    {
        return $this->confirmada;
    }

    public function setConfirmada(bool $confirmada): static
    {
        $this->confirmada = $confirmada;

        return $this;
    }
}
