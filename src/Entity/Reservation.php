<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $confirmed = null;

    // #[ORM\OneToMany(mappedBy: 'reservation_ride', targetEntity: Ride::class)]
    // private Collection $ride;

    #[ORM\ManyToOne(inversedBy: 'reservations_ride')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ride $ride = null;


    #[ORM\ManyToOne(inversedBy: 'user_reservation')]
    private ?User $passenger = null;


    // public function __construct()
    // {
    //     $this->ride = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getRide(): ?Ride
    {
        return $this->ride;
    }

    public function setRide(?Ride $ride): self
    {
        $this->ride = $ride;

        return $this;
    }

    public function getPassenger(): ?User
    {
        return $this->passenger;
    }

    public function setPassenger(?User $passenger): self
    {
        $this->passenger = $passenger;

        return $this;
    }


    // /**
    //  * @return Collection<int, Ride>
    //  */
    // public function getRide(): Collection
    // {
    //     return $this->ride;
    // }

    // public function addRide(Ride $ride): self
    // {
    //     if (!$this->ride->contains($ride)) {
    //         $this->ride->add($ride);
    //         $ride->setReservationRide($this);
    //     }

    //     return $this;
    // }

    // public function removeRide(Ride $ride): self
    // {
    //     if ($this->ride->removeElement($ride)) {
    //         // set the owning side to null (unless already changed)
    //         if ($ride->getReservationRide() === $this) {
    //             $ride->setReservationRide(null);
    //         }
    //     }

    //     return $this;
    // }

   
}
