<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Permet de vérifier la présence d'un slug en base
     * 
     * @param string $slug
     * 
     * @return bool
     */
    public function checkSlug(string $slug): bool
    {
        $res = false;
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT count(id) AS nb FROM app_user WHERE slug = :slug;";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $res = $stmt->fetch();

        $res = ($res['nb'] > 0 ? true : false);

        return $res;
    }

    /**
     * Permet de compter le nombre d'utilisateurs présents en base
     * 
     * @return array
     */
    public function userCount(): array
    {
        $res = false;
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT count(id) AS nb FROM app_user
            UNION ALL
            SELECT count(id) FROM app_user WHERE active
            UNION ALL
            SELECT count(id) FROM app_user WHERE not active";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();

        if (is_array($res) && count($res) == 3) {
            $res = [
                'total' => $res[0]['nb'],
                'actif' => $res[1]['nb'],
                'inactif' => $res[2]['nb'],
            ];
        } else {
            $res = false;
        }

        return $res;
    }

    /**
     * Permet de supprimer un utilisateur
     * et tous ses livres associés
     * 
     * @return array
     */
    public function allDelete(int $id): bool
    {
        $res = false;
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE FROM book WHERE user_id = :id;";

        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([
            'id' => $id,
        ]);

        if ($res) {
            $sql = "DELETE FROM app_user WHERE id = :id;";

            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([
                'id' => $id,
            ]);
        }

        return $res;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
