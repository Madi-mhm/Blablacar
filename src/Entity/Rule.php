<?php

namespace App\Entity;

use App\Repository\RuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RuleRepository::class)]
class Rule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'user_rules')]
    private ?User $author = null;

    #[ORM\ManyToMany(targetEntity: Ride::class)]
    private Collection $rule;

   

    public function __construct()
    {
        $this->ride = new ArrayCollection();
        $this->rule = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Ride>
     */
    public function getRule(): Collection
    {
        return $this->rule;
    }

    public function addRule(Ride $rule): self
    {
        if (!$this->rule->contains($rule)) {
            $this->rule->add($rule);
        }

        return $this;
    }

    public function removeRule(Ride $rule): self
    {
        $this->rule->removeElement($rule);

        return $this;
    }

}
