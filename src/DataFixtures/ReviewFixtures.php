<?php

namespace App\DataFixtures;

use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $review = new Review();
        $review
            ->setAuthor('Jan Kowalski')
            ->setBook($this->getReference(BookFixtures::BOOK . 1))
            ->setRating(10)
            ->setReview('Doskonała ksiażka')
            ->setCreatedAt(new \DateTimeImmutable())
        ;
        $manager->persist($review);

        $review2 = new Review();
        $review2
            ->setAuthor('Andrzej Nowak')
            ->setBook($this->getReference(BookFixtures::BOOK . 2))
            ->setRating(8)
            ->setReview('Zakończenie lekko rozczarowujące')
            ->setCreatedAt(new \DateTimeImmutable())
        ;
        $manager->persist($review2);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            BookFixtures::class
        );
    }
}
