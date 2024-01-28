<?php

namespace App\MessageHandler;

use App\Entity\Book;
use App\Entity\BookAvailability;
use App\Entity\Rental;
use App\Entity\User;
use App\Message\RentBook;

use App\Service\EdifactService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RentBookHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EdifactService $edifactService,
        private readonly LoggerInterface $logger
    ) {}

    public function __invoke(RentBook $rentBook)
    {
        $data = $this->edifactService->parseEDIFACTRentMessage($rentBook->getContent());
        $book = $this->entityManager->getRepository(Book::class)->find($data['itemId']);
        $user = $this->entityManager->getRepository(User::class)->find($data['userId']);

        if(!$book) {
            $this->logger->alert(sprintf('Nie moge wyszukac pozycji o ID %d', $data['itemId']));
            return;
        }

        if(!$user) {
            $this->logger->alert(sprintf('Nie moge wyszukac uzytkownika o ID %d', $data['itemId']));
            return;
        }

        // Aktualizacja stanu dostępności
        $availability = $book->getAvailability();
        $availability->setAvailable($availability->getAvailable() - 1);

        $this->entityManager->persist($availability);

        // Rekord wypożyczenia
        $rental = new Rental();
        $rental
            ->setItemId($book)
            ->setUserId($user)
            ->setRentFrom($data['rentFrom'])
            ->setRentTo($data['rentTo']);
        $this->entityManager->persist($rental);

        $this->entityManager->flush();

    }
}