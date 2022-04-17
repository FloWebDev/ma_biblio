<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Permet de supprimer une catégorie APRES
     * avoir associé tous ses livres à la catégorie "master"
     * 
     * @param int $id - ID de la catégorié à supprimer
     * 
     * @return array
     */
    public function categoryDelete(int $id): bool
    {
        $res = false;
        $conn = $this->getEntityManager()->getConnection();

        // On met à jour tous les livres associés à la catégorie à supprimer
        // pour qu'ils soient rattachés à la catégorie "master" (de référence)
        $sql = "UPDATE book
            SET category_id = (SELECT id FROM category WHERE reference = 'master')
            WHERE category_id = :id";

        $stmt = $conn->prepare($sql);
        $res = $stmt->executeStatement([
            'id' => $id,
        ]);

        if ($res) {
            // Puis on supprime la catégorie demandée
            $sql = "DELETE FROM category WHERE id = :id;";

            $stmt = $conn->prepare($sql);
            $res = $stmt->executeStatement([
                'id' => $id,
            ]);
        }

        return $res;
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
