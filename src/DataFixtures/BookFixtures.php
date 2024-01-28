<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class BookFixtures  extends Fixture implements DependentFixtureInterface
{
    public const BOOK = 'book_';

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $book = new Book();
        $book
            ->setName('Lalka')
            ->setDescription('Słynna powieść Bolesława Prusa')
            ->addAuthor($this->getReference(AuthorFixtures::AUTHOR . 1));
        $this->addReference(self::BOOK . '1', $book);

        $manager->persist($book);

        $book2 = new Book();
        $book2
            ->setName('Limes Inferior')
            ->setDescription('Zostań lifterem jak Sneer')
            ->addAuthor($this->getReference(AuthorFixtures::AUTHOR . 2));
        $this->addReference(self::BOOK . '2', $book2);

        $manager->persist($book2);

        $book3 = new Book();
        $book3
            ->setName('Solaris')
            ->setDescription('Jedna z najpopularniejszych ksiażek króla Polskiej Fantastyki')
            ->addAuthor($this->getReference(AuthorFixtures::AUTHOR . 3));
        $this->addReference(self::BOOK . '3', $book3);

        $manager->persist($book3);

        $book4 = new Book();
        $book4
            ->setName('Mord założycielski')
            ->setDescription('Powieść z nurtu fantastyki socjologicznej autorstwa Edmunda Wnuka-Lipińskiego, wydana po raz pierwszy w 1989 roku.')
            ->addAuthor($this->getReference(AuthorFixtures::AUTHOR . 4));
        $this->addReference(self::BOOK . '4', $book4);

        $manager->persist($book4);

        $book5 = new Book();
        $book5
            ->setName('Kolory sztandardów')
            ->setDescription('Powieść fantastycznonaukowa Tomasza Kołodziejczaka. Opublikowana w 1996 nakładem superNOWej')
            ->addAuthor($this->getReference(AuthorFixtures::AUTHOR . 5));
        $this->addReference(self::BOOK . '5', $book5);

        $manager->persist($book5);

        $book6 = new Book();
        $book6
            ->setName('Kordian')
            ->setDescription(null)
            ->addAuthor($this->getReference(AuthorFixtures::AUTHOR . 6));
        $this->addReference(self::BOOK . '6', $book6);

        $manager->persist($book6);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            AuthorFixtures::class
        );
    }

}
