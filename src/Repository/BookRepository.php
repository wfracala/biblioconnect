<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param string $value
     * @return Book|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByAuthorOrTitle(string $value): array
    {
        return $this->createQueryBuilder('b')
            ->addSelect('b')
            ->leftJoin('b.author', 'a')
            ->andWhere("b.name LIKE :val or a.name LIKE :val")
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
        ;
    }
}
