<?php

namespace App\Command;

use App\Entity\Post;
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

        // Création des posts initiaux
        $post = new Post();
        $post->setTopic('index1');
        $post->setBody("Créez gratuitement votre bibliothèque virtuelle en y ajoutant tous vos livres.");
        $post->setOrderZ(1);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('index1');
        $post->setBody("Aucune application à télécharger. Appication 100% responsive (s'adapte à toutes les tailles d'écran).");
        $post->setOrderZ(2);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('index1');
        $post->setBody("Créez vos listes de lectures (lus, en cours, whish-list, abandonnés) et donner une note à chacun de vos livres.");
        $post->setOrderZ(3);
        $this->em->persist($post);

        $post = new Post();
        $post->setTopic('index2');
        $post->setBody("Créez votre profil de lecteur et votre bibliothèque, et partagez-les sur les réseaux sociaux.");
        $post->setOrderZ(1);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('index2');
        $post->setBody("Accéder au profil des autres lecteurs pour consulter leurs bibliothèques, et vous donner ainsi de nouvelles envies.");
        $post->setOrderZ(2);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('index2');
        $post->setBody("Vous restez libre de rendre privés ou publics votre profil et votre bibliothèque à tout moment.");
        $post->setOrderZ(3);
        $this->em->persist($post);

        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setBody("Conformément aux dispositions des Articles 6-III et 19 de la Loi n°2004-575 du 21 juin 2004 pour la Confiance dans l’économie numérique, dite L.C.E.N., il est porté à la connaissance des utilisateurs du site www.example.com les présentes mentions légales. La connexion et la navigation sur le site SITE par l’utilisateur implique acceptation intégrale et sans réserve des présentes mentions légales.");
        $post->setOrderZ(1);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 1 : L'ÉDITEUR");
        $post->setBody("L'édition du site www.example.com est assurée par PRENOM NOM à titre personnel et sans but lucratif, adresse e-mail : adresse@mail.net. Le Responsable de la publication est PRENOM NOM.");
        $post->setOrderZ(2);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 2 : L'HÉBERGEUR");
        $post->setBody("L'hébergeur du site SITE est la SAS OVH, dont le siège social est situé au 2 rue Kellermann - 59100 Roubaix - France.");
        $post->setOrderZ(3);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 3 : ACCÈS AU SITE");
        $post->setBody("Le site est accessible par tout endroit, 7j/7, 24h/24 sauf cas de force majeure, interruption programmée ou non et pouvant découlant d’une nécessité de maintenance. En cas de modification, interruption ou suspension des services le site www.example.com ne saurait être tenu responsable.");
        $post->setOrderZ(4);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 4 : COLLECTE DES DONNÉES");
        $post->setBody("Le site est exempté de déclaration à la Commission Nationale Informatique et Libertés (CNIL) dans la mesure où il ne collecte aucune donnée concernant les utilisateurs.");
        $post->setOrderZ(5);
        $this->em->persist($post);
        $post = new Post();
        $post->setTopic('mentions_legales');
        $post->setTitle("ARTICLE 5 : PROPRIÉTÉ INTELLECTUELLE");
        $post->setBody("Toute utilisation, reproduction, diffusion, commercialisation, modification de toute ou partie du site www.example.com, sans autorisation de l’éditeur est prohibée et pourra entraînée des actions et poursuites judiciaires telles que notamment prévues par le Code de la propriété intellectuelle et le Code civil.");
        $post->setOrderZ(6);
        $this->em->persist($post);

        $post = new Post();
        $post->setTopic('faq');
        $post->setTitle("Question 1");
        $post->setBody("A venir.");
        $post->setOrderZ(1);
        $this->em->persist($post);


        $this->em->flush();

        echo "Génération des données initiales terminées\n";

        return 0;
    }
}