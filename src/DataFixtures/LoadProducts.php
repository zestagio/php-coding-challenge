<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Exception\LoadDataFixtureRuntimeException;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadProducts extends Fixture implements DependentFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function getDependencies(): array
    {
        return [LoadCategories::class];
    }

    /**
     * {@inheritDoc}
     *
     * @throws LoadDataFixtureRuntimeException
     */
    public function load(ObjectManager $manager): void
    {
        /** @var array{name: string, category: string, sku: string, price: float, quantity: int, createdBy: string} $productData */
        foreach ($this->getProducts() as $productData) {
            $user = $this->getReference($productData['createdBy']);
            if (!$user instanceof User) {
                throw new LoadDataFixtureRuntimeException('Can\'t get user from reference');
            }

            $category = $this->getReference($productData['category']);
            if (!$category instanceof Category) {
                throw new LoadDataFixtureRuntimeException('Can\'t get category from reference');
            }

            $product = (new Product())
                ->setName($productData['name'])
                ->setCategory($category)
                ->setSku($productData['sku'])
                ->setPrice($productData['price'])
                ->setQuantity($productData['quantity'])
                ->setCreatedAt(new DateTime())
                ->setCreatedBy($user);

            $manager->persist($product);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    private function getProducts(): array
    {
        return [
            [
                'name' => 'Product A',
                'category' => 'Category A',
                'sku' => 'product_a',
                'price' => 10.5,
                'quantity' => 10,
                'createdBy' => 'john.doe@example.com',
            ],
            [
                'name' => 'Product B',
                'category' => 'Category B',
                'sku' => 'product_b',
                'price' => 1,
                'quantity' => 100,
                'createdBy' => 'amanda.cole@example.com',
            ],
            [
                'name' => 'Product C',
                'category' => 'Category C',
                'sku' => 'product_c',
                'price' => 115,
                'quantity' => 1,
                'createdBy' => 'john.doe@example.com',
            ],
        ];
    }
}
