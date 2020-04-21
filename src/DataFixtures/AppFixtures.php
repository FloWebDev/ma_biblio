<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Book;
use App\Entity\Post;
use App\Entity\Role;
use App\Entity\User;
use App\Util\Slugger;
use App\Entity\Category;
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
        $category1->setReference('master');
        $category1->setName('Livres lus');
        $category1->setCss('info');
        $category1->setOrderZ(1);
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('Lectures');
        $category2->setCss('success');
        $category2->setOrderZ(2);
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('Pile à lire (PAL)');
        $category3->setCss('secondary');
        $category3->setOrderZ(3);
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setName('Whish-List');
        $category4->setCss('warning');
        $category4->setOrderZ(4);
        $manager->persist($category4);

        $category5 = new Category();
        $category5->setName('Abandonnés');
        $category5->setCss('danger');
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

        // Création des posts

        $post = new Post();
        $post->setTopic('index1');
        $post->setBody("Créez gratuitement votre bibliothèque virtuelle en y ajoutant tous vos livres.");
        $post->setOrderZ(1);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('index1');
        $post->setBody("Aucune application à télécharger. Appication 100% responsive (s'adapte à toutes les tailles d'écran).");
        $post->setOrderZ(2);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('index1');
        $post->setBody("Créez vos listes de lectures (lus, en cours, whish-list, abandonnés) et donner une note à chacun de vos livres.");
        $post->setOrderZ(3);
        $manager->persist($post);

        $post = new Post();
        $post->setTopic('index2');
        $post->setBody("Créez votre profil de lecteur et votre bibliothèque, et partagez-les sur les réseaux sociaux.");
        $post->setOrderZ(1);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('index2');
        $post->setBody("Accéder au profil des autres lecteurs pour consulter leurs bibliothèques, et vous donner ainsi de nouvelles envies.");
        $post->setOrderZ(2);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('index2');
        $post->setBody("Vous restez libre de rendre privés ou publics votre profil et votre bibliothèque à tout moment.");
        $post->setOrderZ(3);
        $manager->persist($post);

        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setBody("Conformément aux dispositions des Articles 6-III et 19 de la Loi n°2004-575 du 21 juin 2004 pour la Confiance dans l’économie numérique, dite L.C.E.N., il est porté à la connaissance des utilisateurs du site www.example.com les présentes mentions légales. La connexion et la navigation sur le site SITE par l’utilisateur implique acceptation intégrale et sans réserve des présentes mentions légales.");
        $post->setOrderZ(1);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 1 : L'ÉDITEUR");
        $post->setBody("L'édition du site www.example.com est assurée par PRENOM NOM à titre personnel et sans but lucratif, adresse e-mail : adresse@mail.net. Le Responsable de la publication est PRENOM NOM.");
        $post->setOrderZ(2);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 2 : L'HÉBERGEUR");
        $post->setBody("L'hébergeur du site SITE est la SAS OVH, dont le siège social est situé au 2 rue Kellermann - 59100 Roubaix - France.");
        $post->setOrderZ(3);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 3 : ACCÈS AU SITE");
        $post->setBody("Le site est accessible par tout endroit, 7j/7, 24h/24 sauf cas de force majeure, interruption programmée ou non et pouvant découlant d’une nécessité de maintenance. En cas de modification, interruption ou suspension des services le site www.example.com ne saurait être tenu responsable.");
        $post->setOrderZ(4);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 4 : COLLECTE DES DONNÉES");
        $post->setBody("Le site est exempté de déclaration à la Commission Nationale Informatique et Libertés (CNIL) dans la mesure où il ne collecte aucune donnée concernant les utilisateurs.");
        $post->setOrderZ(5);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 5 : PROPRIÉTÉ INTELLECTUELLE");
        $post->setBody("Toute utilisation, reproduction, diffusion, commercialisation, modification de toute ou partie du site www.example.com, sans autorisation de l’éditeur est prohibée et pourra entraînée des actions et poursuites judiciaires telles que notamment prévues par le Code de la propriété intellectuelle et le Code civil.");
        $post->setOrderZ(6);
        $manager->persist($post);

        $post = new Post();
        $post->setTopic('faq');
        $post->setTitle("Question 1");
        $post->setBody("lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum.");
        $post->setOrderZ(1);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('faq');
        $post->setTitle("Question 2");
        $post->setBody("lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum.");
        $post->setOrderZ(2);
        $manager->persist($post);
        $post = new Post();
        $post->setTopic('faq');
        $post->setTitle("Question 3");
        $post->setBody("lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum.");
        $post->setOrderZ(3);
        $manager->persist($post);

        $manager->flush();

        echo "Génération des fixtures terminées\n";
    }
}
