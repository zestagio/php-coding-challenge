<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\EventListener\CreateUpdateEntityListener;
use App\Repository\CategoryRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\EntityListeners([CreateUpdateEntityListener::class])]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    denormalizationContext: ['groups' => ['category:write']],
    normalizationContext: ['groups' => ['category:read']]
)]
class Category implements
    CreatedAtAwareInterface,
    UpdatedAtAwareInterface,
    CreatedByAwareInterface,
    UpdatedByAwareInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['category:read', 'product:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['category:read', 'product:read'])]
    private ?string $name = null;

    #[ORM\Column(type: 'datetime', columnDefinition: 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP')]
    private ?DateTime $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true, columnDefinition: 'TIMESTAMP NULL DEFAULT NULL')]
    private ?DateTime $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserInterface $createdBy = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?UserInterface $updatedBy = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt(?DateTime $updatedAt = null): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedBy(): ?UserInterface
    {
        return $this->createdBy;
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedBy(UserInterface $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedBy(): ?UserInterface
    {
        return $this->updatedBy;
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedBy(?UserInterface $updatedBy = null): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
}
