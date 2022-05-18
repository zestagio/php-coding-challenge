<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\GetProductsTotalValueController;
use App\EventListener\CreateUpdateEntityListener;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\EntityListeners([CreateUpdateEntityListener::class])]
#[UniqueEntity('sku')]
#[ApiResource(
    collectionOperations: [
        'get',
        'get_products_total_value' => [
            'method' => 'GET',
            'path' => '/products/total-value.{_format}',
            'controller' => GetProductsTotalValueController::class,
            'pagination_enabled' => false,
            'openapi_context' => [
                'description' => 'Retrieves the total value of all products that are in store.',
                'summary' => 'Retrieves the total value of all products that are in store.',
            ],
        ],
        'post' => ['security' => "is_granted('IS_AUTHENTICATED_FULLY')"],
    ],
    itemOperations: [
        'get',
        'patch' => ['security' => "is_granted('IS_AUTHENTICATED_FULLY')"],
        'delete' => ['security' => "is_granted('IS_AUTHENTICATED_FULLY')"],
    ],
    denormalizationContext: ['groups' => ['product:write']],
    normalizationContext: ['groups' => ['product:read']]
)]
class Product implements
    CreatedAtAwareInterface,
    UpdatedAtAwareInterface,
    CreatedByAwareInterface,
    UpdatedByAwareInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read', 'product:write'])]
    #[NotBlank]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product:read', 'product:write'])]
    #[NotBlank]
    private ?Category $category = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['product:read', 'product:write'])]
    #[NotBlank]
    private ?string $sku = null;

    #[ORM\Column(type: 'decimal', precision: 7, scale: 2)]
    #[Groups(['product:read', 'product:write'])]
    #[NotBlank]
    #[GreaterThanOrEqual(value: 0)]
    private ?float $price = null;

    #[ORM\Column(type: 'integer')]
    #[Groups(['product:read', 'product:write'])]
    #[NotBlank]
    #[GreaterThanOrEqual(value: 0)]
    #[Type(type: 'integer')]
    private ?int $quantity = null;

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
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     *
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     *
     * @return $this
     */
    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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
