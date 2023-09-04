<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: ModuleData::class, cascade: ["persist"])]
    private Collection $moduleData;

    public function __construct()
    {
        $this->moduleData = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, ModuleData>
     */
    public function getModuleData(): Collection
    {
        return $this->moduleData;
    }

    public function addModuleData(ModuleData $moduleData): self
    {
        if (!$this->moduleData->contains($moduleData)) {
            $this->moduleData->add($moduleData);
            $moduleData->setModule($this);
        }

        return $this;
    }

    public function removeModuleData(ModuleData $moduleData): self
    {
        if ($this->moduleData->removeElement($moduleData)) {
            if ($moduleData->getModule() === $this) {
                $moduleData->setModule(null);
            }
        }

        return $this;
    }
}
