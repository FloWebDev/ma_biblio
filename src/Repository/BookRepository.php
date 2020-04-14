<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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
     * Permet d'avoir le compte des books par catégorie
     * pour un utilisateur
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function getAverageNote(int $id)
    {
        $res = false;
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT AVG(book.note) AS moy
            FROM book
            WHERE book.user_id = :id
            AND note IS NOT NULL;";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch();

        return $res['moy'];
    }

    /**
     * Permet d'avoir le compte des books par catégorie
     * pour un utilisateur
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function getBookByCategoryAndUser(int $id)
    {
        $res = false;
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT COUNT(book.id) AS nb, category.name AS category_name 
            FROM category
            LEFT JOIN book ON category.id = book.category_id AND book.user_id = :id
            GROUP BY category.name
            ORDER BY category.order_z ASC;";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetchAll();

        return $res;
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
