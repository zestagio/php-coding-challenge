<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoadUsers extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager): void
    {
        /** @var array{email: string, password: string} $userData */
        foreach ($this->getUsers() as $userData) {
            $user = new User();
            $user->setEmail($userData['email'])
                ->setPassword($this->hasher->hashPassword($user, $userData['password']));

            $manager->persist($user);

            $this->addReference($user->getEmail(), $user);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    private function getUsers(): array
    {
        return [
            ['email' => 'john.doe@example.com', 'password' => 'password1'],
            ['email' => 'amanda.cole@example.com', 'password' => 'password2'],
        ];
    }
}
