<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EntityWithDeletableRelationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntityWithDeletableRelationRepository::class)]
class EntityWithDeletableRelation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?DeletableEntity $relatedDeletableEntity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getRelatedDeletableEntity(): ?DeletableEntity
    {
        return $this->relatedDeletableEntity;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setRelatedDeletableEntity(?DeletableEntity $relatedDeletableEntity): static
    {
        $this->relatedDeletableEntity = $relatedDeletableEntity;

        return $this;
    }
}
