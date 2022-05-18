<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Exception\LoadDataFixtureRuntimeException;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadCategories extends Fixture implements DependentFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function getDependencies(): array
    {
        return [LoadUsers::class];
    }

    /**
     * {@inheritDoc}
     *
     * @throws LoadDataFixtureRuntimeException
     */
    public function load(ObjectManager $manager): void
    {
        /** @var array{name: string, createdBy: string} $categoryData */
        foreach ($this->getCategories() as $categoryData) {
            $user = $this->getReference($categoryData['createdBy']);
            if (!$user instanceof User) {
                throw new LoadDataFixtureRuntimeException('Can\'t get user from reference');
            }

            $category = (new Category())
                ->setName($categoryData['name'])
                ->setCreatedAt(new DateTime())
                ->setCreatedBy($user);

            $manager->persist($category);

            $this->addReference($category->getName(), $category);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    private function getCategories(): array
    {
        return [
            ['name' => 'Category A', 'createdBy' => 'john.doe@example.com'],
            ['name' => 'Category B', 'createdBy' => 'amanda.cole@example.com'],
            ['name' => 'Category C', 'createdBy' => 'john.doe@example.com'],
        ];
    }
}
