<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use App\Util\Slugger;
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
        }

        $manager->flush();

        echo "Génération des fixtures terminées\n";
    }
}
