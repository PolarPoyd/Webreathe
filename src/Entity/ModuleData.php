<?php

namespace App\Entity;

use App\Repository\ModuleDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleDataRepository::class)]
class ModuleData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $temperature = null;

    #[ORM\Column(length: 255)]
    private ?string $energy = null;

    #[ORM\Column]
    private ?bool $broken = false;

    #[ORM\ManyToOne(inversedBy: 'moduleData', cascade: ["persist", "remove"])]
    private ?Module $module = null;

    #[ORM\Column(length: 255)]
    private ?string $speed = null;

    #[ORM\Column(length: 255)]
    private ?string $flow = null;    
    
    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function isBroken(): ?bool
    {
        return $this->broken;
    }

    public function setBroken(bool $broken): static
    {
        $this->broken = $broken;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }
    

    /**
     * Get the value of broken
     *
     * @return ?bool
     */
    public function getBroken(): ?bool
    {
        return $this->broken;
    }

    public function getSpeed(): ?string
    {
        return $this->speed;
    }

    public function setSpeed(string $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getFlow(): ?string
    {
        return $this->flow;
    }

    public function setFlow(string $flow): static
    {
        $this->flow = $flow;

        return $this;
    }


}
