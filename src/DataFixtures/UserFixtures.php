<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setPassword(
            $this->userPasswordHasher->hashPassword(
                $admin,
                '12345678'
            )
        );
        $admin
            ->setRoles(['ROLE_ADMIN'])
            ->setLastName('admin')
            ->setFirstName('admin')
            ->setEmail('admin@biblioconnect.com')
            ->setAddress('Sezamkowa 12, Laponia')
        ;

        $manager->persist($admin);
        $manager->flush();
    }
}
