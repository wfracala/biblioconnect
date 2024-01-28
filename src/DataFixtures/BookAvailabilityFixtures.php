<?php

namespace App\DataFixtures;

use App\Entity\BookAvailability;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class BookAvailabilityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=6; $i++) {
            $bookAvailability = new BookAvailability();
            $bookAvailability
                ->setBook($this->getReference(BookFixtures::BOOK . $i))
                ->setAvailable(10)
                ->setTotal(10)
            ;

            $manager->persist($bookAvailability);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            BookFixtures::class
        );
    }
}
