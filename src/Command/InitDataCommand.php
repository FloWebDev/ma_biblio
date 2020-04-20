<?php

namespace App\Command;

use App\Entity\Role;
use App\Entity\User;
use App\Util\Slugger;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @link https://symfony.com/doc/current/console.html
 */
class InitDataCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'init:data';
    private $em;
    private $passwordEncoder;
    private $slugger;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, Slugger $slugger)
    {
        parent::__construct();

        $this->em = $em;
        $this->passwordEncoder = $encoder;
        $this->slugger = $slugger;
    }

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Permet de créer les données de départ (rôles, catégories, administrateurs).')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Cette commande permet de créer les données de départ pour la table des rôles, des catégories et des utilisateurs (les administrateurs). Sans l\'utlisation préalable de cette commande, le site ne pourra pas fonctionner correctement.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Création du rôle ROLE_ADMIN
        $adminRole = new Role();
        $adminRole->setCode('ROLE_ADMIN');
        $adminRole->setName('administrateur');
        $this->em->persist($adminRole);

        // Création du rôle ROLE_USER
        $userRole = new Role();
        $userRole->setCode('ROLE_USER');
        $userRole->setName('utilisateur');
        $this->em->persist($userRole);

        // Création des catégories initiales
        $category1 = new Category();
        $category1->setReference('master');
        $category1->setName('Livres lus');
        $category1->setCss('info');
        $category1->setOrderZ(1);
        $this->em->persist($category1);

        $category2 = new Category();
        $category2->setName('Lectures');
        $category2->setCss('success');
        $category2->setOrderZ(2);
        $this->em->persist($category2);

        $category3 = new Category();
        $category3->setName('Pile à lire (PAL)');
        $category3->setCss('secondary');
        $category3->setOrderZ(3);
        $this->em->persist($category3);

        $category4 = new Category();
        $category4->setName('Whish-List');
        $category4->setCss('warning');
        $category4->setOrderZ(4);
        $this->em->persist($category4);

        $category5 = new Category();
        $category5->setName('Abandonnés');
        $category5->setCss('danger');
        $category5->setOrderZ(5);
        $this->em->persist($category5);

        // Création de l'utilisateur Administrateur
        $adminUser = new User();
        $adminUser->setUsername('admin');
        $encodedPassword = $this->passwordEncoder->encodePassword($adminUser, 'admin');
        $slug = $this->slugger->sluggify('admin');
        $adminUser->setPassword($encodedPassword);
        $adminUser->setSlug($slug);
        $adminUser->setEmail('admin@gmail.com');
        $adminUser->setRole($adminRole);
        $this->em->persist($adminUser);

        $this->em->flush();

        echo "Génération des données initiales terminées\n";

        return 0;
    }
}