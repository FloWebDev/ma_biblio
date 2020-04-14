<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Role;
use App\Entity\User;
use App\Util\Slugger;
use App\Entity\Category;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $slugger;

    /**
     * Constructor de la class permettant d'injecter des services
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, Slugger $slugger)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->slugger = $slugger;
    }

    /**
     * Méthode appelée pour la génération des fixtures
     * 
     */
    public function load(ObjectManager $manager)
    {
        // Création des catégories intiales
        $category1 = new Category();
        $category1->setReference('ct' . uniqid());
        $category1->setName('Livres lus');
        $category1->setOrderZ(1);
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setReference('ct' . uniqid());
        $category2->setName('Lectures');
        $category2->setOrderZ(2);
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setReference('ct' . uniqid());
        $category3->setName('Pile à lire (PAL)');
        $category3->setOrderZ(3);
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setReference('ct' . uniqid());
        $category4->setName('Whish-List');
        $category4->setOrderZ(4);
        $manager->persist($category4);

        $category5 = new Category();
        $category5->setReference('ct' . uniqid());
        $category5->setName('Abandonnés');
        $category5->setOrderZ(5);
        $manager->persist($category5);

        $categories = [
            $category1,
            $category2,
            $category3,
            $category4,
            $category5
        ];

        // Création du rôle ROLE_ADMIN
        $adminRole = new Role();
        $adminRole->setCode('ROLE_ADMIN');
        $adminRole->setName('administrateur');
        $manager->persist($adminRole);

        // Création du rôle ROLE_USER
        $userRole = new Role();
        $userRole->setCode('ROLE_USER');
        $userRole->setName('utilisateur');
        $manager->persist($userRole);

        // Création de l'utilisateur Administrateur
        $adminUser = new User();
        $adminUser->setUsername('admin');
        $encodedPassword = $this->passwordEncoder->encodePassword($adminUser, 'admin');
        $slug = $this->slugger->sluggify('admin');
        $adminUser->setPassword($encodedPassword);
        $adminUser->setSlug($slug);
        $adminUser->setEmail('admin@bookstore.com');
        $adminUser->setRole($adminRole);
        $manager->persist($adminUser);

        for ($b = 1; $b <= 30; $b++) {
            $book = new Book();
            $book->setReference('bk' . uniqid());
            $book->setTitle('Titre Livre' . $b);
            $book->setSubtitle('blabla blabla blabla');
            $book->setAuthor('Auteur' . $b . '#' . 'Auteur' . ($b+1));
            $book->setDescription('lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum');
            $book->setPublishedDate(1970 + $b);
            $book->setIsbn13('1234567891234');
            $book->setIsbn10('1234567890');
            $book->setImage('http://books.google.com/books/content?id=PVaa4TnXveAC&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api');
            $book->setLitteralCategory('Catégorie' . $b . '#' . 'Catégorie' . ($b+1));
            $book->setNote(random_int(1, 20));
            if ($b % 3 == 0) {
                $book->setComment('Très bon livre ! Je recommande.');
            }
            $book->setUser($adminUser);
            shuffle($categories);
            $book->setCategory($categories[0]);
            $manager->persist($book);
        }

        // Créatio de l'utilisateur Utilisateur
        $user = new User();
        $user->setUsername('user');
        $encodedPassword = $this->passwordEncoder->encodePassword($user, 'user');
        $slug = $this->slugger->sluggify('user');
        $user->setPassword($encodedPassword);
        $user->setSlug($slug);
        $user->setEmail('user@bookstore.com');
        $user->setRole($userRole);
        $manager->persist($user);

        for ($b = 1; $b <= 20; $b++) {
            $book = new Book();
            $book->setReference('bk' . uniqid());
            $book->setTitle('Titre Livre' . $b);
            $book->setSubtitle('blabla blabla blabla');
            $book->setAuthor('Auteur' . $b . '#' . 'Auteur' . ($b+1));
            $book->setDescription('lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum');
            $book->setPublishedDate(1970 + $b);
            $book->setIsbn13('1234567891234');
            $book->setIsbn10('1234567890');
            $book->setImage('http://books.google.com/books/content?id=PVaa4TnXveAC&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api');
            $book->setLitteralCategory('Catégorie' . $b . '#' . 'Catégorie' . ($b+1));
            $book->setNote(random_int(1, 20));
            if ($b % 3 == 0) {
                $book->setComment('Très bon livre ! Je recommande.');
            }
            $book->setUser($user);
            shuffle($categories);
            $book->setCategory($categories[0]);
            $manager->persist($book);
        }

        // Création de plusieurs utilisateurs fictifs
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setUsername('usedséèçAlàA' . $i);
            $encodedPassword = $this->passwordEncoder->encodePassword($user, 'user' . $i);
            $slug = $this->slugger->sluggify('usedséèçAlàA' . $i);
            $user->setPassword($encodedPassword);
            $user->setSlug($slug);
            $user->setEmail('user' . $i . '@bookstore.com');
            $user->setRole($userRole);
            $manager->persist($user);

            for ($b = 1; $b <= 15; $b++) {
                $book = new Book();
                $book->setReference('bk' . uniqid());
                $book->setTitle('Titre Livre' . $b);
                $book->setSubtitle('blabla blabla blabla');
                $book->setAuthor('Auteur' . $b . '#' . 'Auteur' . ($b+1));
                $book->setDescription('lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum');
                $book->setPublishedDate(1970 + $b);
                $book->setIsbn13('1234567891234');
                $book->setIsbn10('1234567890');
                $book->setImage('http://books.google.com/books/content?id=PVaa4TnXveAC&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api');
                $book->setLitteralCategory('Catégorie' . $b . '#' . 'Catégorie' . ($b+1));
                $book->setNote(random_int(1, 20));
                if ($b % 3 == 0) {
                    $book->setComment('Très bon livre ! Je recommande.');
                }
                $book->setUser($user);
                shuffle($categories);
                $book->setCategory($categories[0]);
                $manager->persist($book);
            }
        }

        $manager->flush();

        echo "Génération des fixtures terminées\n";
    }
}
