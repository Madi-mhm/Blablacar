<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 80)]
    private ?string $first_name = null;

    #[ORM\Column(length: 80)]
    private ?string $last_name = null;

    #[ORM\Column]
    private ?int $phone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\OneToMany(mappedBy: 'passenger', targetEntity: Reservation::class)]
    private Collection $user_reservation;

    #[ORM\OneToMany(mappedBy: 'driver', targetEntity: Ride::class, orphanRemoval: true)]
    private Collection $user_rides;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Rule::class)]
    private Collection $user_rules;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Car::class, orphanRemoval: true)]
    private Collection $cars;


    public function __construct()
    {
        $this->user_reservation = new ArrayCollection();
        $this->user_rides = new ArrayCollection();
        $this->user_rules = new ArrayCollection();
        $this->cars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getUserReservation(): Collection
    {
        return $this->user_reservation;
    }

    public function addUserReservation(Reservation $userReservation): self
    {
        if (!$this->user_reservation->contains($userReservation)) {
            $this->user_reservation->add($userReservation);
            $userReservation->setPassenger($this);
        }

        return $this;
    }

    public function removeUserReservation(Reservation $userReservation): self
    {
        if ($this->user_reservation->removeElement($userReservation)) {
            // set the owning side to null (unless already changed)
            if ($userReservation->getPassenger() === $this) {
                $userReservation->setPassenger(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, Ride>
     */
    public function getUserRides(): Collection
    {
        return $this->user_rides;
    }

    public function addUserRide(Ride $userRide): self
    {
        if (!$this->user_rides->contains($userRide)) {
            $this->user_rides->add($userRide);
            $userRide->setDriver($this);
        }

        return $this;
    }

    public function removeUserRide(Ride $userRide): self
    {
        if ($this->user_rides->removeElement($userRide)) {
            // set the owning side to null (unless already changed)
            if ($userRide->getDriver() === $this) {
                $userRide->setDriver(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, Rule>
     */
    public function getUserRules(): Collection
    {
        return $this->user_rules;
    }

    public function addUserRule(Rule $userRule): self
    {
        if (!$this->user_rules->contains($userRule)) {
            $this->user_rules->add($userRule);
            $userRule->setAuthor($this);
        }

        return $this;
    }

    public function removeUserRule(Rule $userRule): self
    {
        if ($this->user_rules->removeElement($userRule)) {
            // set the owning side to null (unless already changed)
            if ($userRule->getAuthor() === $this) {
                $userRule->setAuthor(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setOwner($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getOwner() === $this) {
                $car->setOwner(null);
            }
        }

        return $this;
    }
}

