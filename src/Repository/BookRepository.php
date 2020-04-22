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
     * Permet d'avoir le nombre total de livres enregistrés
     * 
     * @return int
     */
    public function getBookCount(): ?int
    {
        $res = false;
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT COUNT(id) AS nb FROM book";

        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $res = $stmt->fetch();

        return $res['nb'];
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

        $sql = "SELECT COUNT(book.id) AS nb, category.name AS category_name, category.css AS css
            FROM category
            LEFT JOIN book ON category.id = book.category_id AND book.user_id = :id
            GROUP BY category.name, category.css, category.order_z
            ORDER BY category.order_z ASC, category.name ASC;";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetchAll();

        return $res;
    }

    /**
     * Permet de vérifier la présence d'un slug en base
     * 
     * @param int|null $categoryId
     * @param array $order
     * 
     * @return Book[]
     */
    public function getBookList(int $id, ?int $categoryId = null, $order)
    {
        $books = $this->createQueryBuilder('book')
            ->andWhere('book.user = :id')
            ->setParameter('id', $id)
            ->leftJoin('book.category', 'book_cat');

        if (!is_null($categoryId)) {
            $books->andWhere('book_cat.id = :cat_id')
                ->setParameter('cat_id', $categoryId);
        }

        if (is_array($order) && count($order) == 2
        && in_array($order[0], ['title', 'note', 'created_at']) 
        && in_array($order[1], ['ASC', 'DESC'])) {
            $books->orderBy('book.'.$order[0], $order[1]);
        } else {
            $books->orderBy('book.title', 'ASC');
        }
        

        return $books->getQuery()->getResult();
    }

    /**
     * Permet de vérifier qu'un livre
     * n'est pas déjà présent pour un utilisateur
     * 
     * @param int $userId
     * @param string $bookRef
     * 
     * @return bool
     */
    public function checkConstraint(int $userId, string $bookRef): bool
    {
        $res = false;
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT count(id) AS nb FROM book
            WHERE user_id = :user_id
            AND reference = :reference;";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'reference' => $bookRef
        ]);
        $res = $stmt->fetch();

        $res = ($res['nb'] > 0 ? true : false);

        return $res;
    }

    /**
     * Permet de vérifier si un file est encore présent sur un book
     *
     * @param $string $file
     * @return bool
     */
    public function checkFile(string $file = null): bool {
        $res = true;

        if (!is_null($file)) {
            $conn = $this->getEntityManager()->getConnection();

            $sql = "SELECT count(id) AS c FROM book WHERE file = :file;";
    
            $stmt = $conn->prepare($sql);
            $stmt->execute(['file' => $file]);
            $res = $stmt->fetch();

            $res = $res['c'] > 0 ? true : false;
        }

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
