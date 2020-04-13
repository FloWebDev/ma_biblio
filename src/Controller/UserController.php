<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Util\Captcha;
use App\Util\Slugger;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Constraints\File as FileValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/profil/{slug}", name="dashboard", methods={"GET", "POST"})
     * @ParamConverter("user", options={"mapping": {"slug": "slug"}})
     */
    public function dashboard(User $user, UserRepository $userRepo, CategoryRepository $categoryRepo, Request $request)
    {
        /**
         * Création du formulaire avatar
         * 
         * @link https://symfony.com/doc/current/form/without_class.html
         */
        $avatarForm = $this->createFormBuilder(null)
        ->add('avatar', FileType::class, [
            'label' => 'Avatar / photo de profil (PNG, JPEG)',
            'attr' => [
            ],
            'constraints' => [
                new FileValidator([
                    'maxSize' => '1024k',
                    'uploadIniSizeErrorMessage' => "L'avatar ne doit pas dépasser une taille de {{ limit }} {{ suffix }}.",
                    'mimeTypes' => [
                        'image/png',
                        'image/jpeg',
                    ],
                    'mimeTypesMessage' => 'L\'avatar doit être au format PNG ou JPEG',
                ])
            ]
        ])->getForm();

        $avatarForm->handleRequest($request);

        if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {
            // Récupération de l'avatar actuel
            $currentAvatar = $user->getAvatar();
            $data = $avatarForm->getData();

            // Gestion de l'avatar
            $avatar = $data['avatar'];

            // this condition is needed because the 'avatar' field is not required
            // so the file must be processed only when a file is uploaded
            if ($avatar) {
                if (!empty($currentAvatar) && $avatar != $currentAvatar) {
                    $fileToDelete = $this->getParameter('avatar_directory') . '/' . $currentAvatar;
                    if (file_exists($fileToDelete)) {
                        unlink($fileToDelete);
                    }
                }

                $safeFilename = uniqid() . time();
                $newFilename = $safeFilename . '.' . $avatar->guessExtension();

                // Move the file to the directory where avatars are stored
                try {
                    $avatar->move(
                        $this->getParameter('avatar_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Erreur lors de l\'upload du fichier');
                }

                // updates the 'avatar' property to store
                $user->setAvatar($newFilename);
            } else {
                $user->setAvatar($currentAvatar);
            }

            // Validation de l'enregistrement en base
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Avatar modifié avec succès.'
            );

            return $this->redirectToRoute('dashboard', [
                'slug' => $user->getSlug()
            ]);
        }

        $books = $categoryRepo->getBookByCategoryAndUser(intval($user->getId()));
        $sqliteVersion = \SQLite3::version();
        $userNumber = $userRepo->userCount();

        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
            'ref' => md5($user->getCreatedAt()->format('Y-m-d H:i:s')) . '-' . $user->getId(),
            'books' => $books,
            'avatar_form' => $avatarForm->createView(),
            'sqlite_version' => $sqliteVersion,
            'userNb' => $userNumber
        ]);
    }

    /**
     * @Route("/inscription", name="sign_up", methods={"GET", "POST"})
     */
    public function signUp(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, Slugger $slugger, Captcha $captcha)
    {
        $newUser = new User();
        $form    = $this->createForm(UserType::class, $newUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            // $user = $form->getData();

            // Création du slug et enregistrement pour le nouvel utlisateur
            $slug = $slugger->sluggify($newUser->getUsername());
            $newUser->setSlug($slug);

            // Encodage du mot de passe
            $encodedPassword = $encoder->encodePassword($newUser, $newUser->getPassword());
            $newUser->setPassword($encodedPassword);

            // Enregistrement du rôle utilisateur par défaut
            $roleRepo = $this->getDoctrine()->getRepository(Role::class);
            $role = $roleRepo->findOneBy(['code' => 'ROLE_USER']);
            $newUser->setRole($role);

            $em->persist($newUser);
            $em->flush();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            $this->addFlash(
                'success',
                'Compte crée avec succès.'
            );

            return $this->redirectToRoute('login');
        }


        return $this->render('user/sign_up.html.twig', [
            'captcha' => $captcha->createCaptcha(),
            'form'            => $form->createView()
        ]);
    }

    /**
     * @Route("/user/{id}/update", name="user_update", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function edit($id, User $user, Request $request, UserPasswordEncoderInterface $encoder, Slugger $slugger)
    {
        // Vérification si utilisateur connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currentUser = $this->getUser();

        if ($currentUser->getId() != $user->getId()) {
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas modifier les informations d\'un tiers.'
            );

            return $this->redirectToRoute('login');
        }

        // Récupération du mot de passe actuellement stocké en BDD
        $currentUsername = $user->getUsername();
        $currentPassword = $user->getPassword();

        /*
         Pour garder un comportement similaire a ce que j'ai en création d'un utilisateur,
         je dois prendre mon nouveau nom de fichier puis le transformer en un objet du type File 
         afin de pouvoir effectuer un guessExtension() etc...
         Sinon a terme je vais stocker une chaine contenant /tmp/789875etc....
         */

        /*
         Actuellement j'autorise dans ma colonne avatar de ma table app_user le nullable. De ce fait, je souhaite convertir mon nom de fichier en type file UNIQUEMENT si celui-ci existe.
        Dans le cas contraire, c'est handlerequest qui se chargera d'effectuer la recuperation d'un objet du type fileUpload comme dans la fonction new
         */
        $currentAvatar = $user->getAvatar();
        if (!empty($currentAvatar)) {
            $file = $this->getParameter('avatar_directory') . '/' . $currentAvatar;
            if (file_exists($file)) {
                $user->setAvatar(new File($file));
            } else {
                $user->setAvatar(null);
            }
        }

        $form    = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            // $user = $form->getData();

            if ($user->getUsername() !== $currentUsername) {
                // On enregistre un nouveau slug qu'en cas de changement de l'identifiant
                $slug = $slugger->sluggify($user->getUsername());
                $user->setSlug($slug);
            }

            // Gestion de la modification du mot de passe
            $newPassword = null;
            if (is_null($user->getPassword())) {
                $newPassword = $currentPassword;
            } else {
                $newPassword = $encoder->encodePassword($user, $user->getPassword());
            }
            $user->setPassword($newPassword);

            // Gestion de l'avatar
            $avatar = $user->getAvatar();
            // $avatar = $form->get('avatar')->getData();

            // this condition is needed because the 'avatar' field is not required
            // so the file must be processed only when a file is uploaded
            if ($avatar) {
                if (!empty($currentAvatar) && $avatar != $currentAvatar) {
                    $fileToDelete = $this->getParameter('avatar_directory') . '/' . $currentAvatar;
                    if (file_exists($fileToDelete)) {
                        unlink($fileToDelete);
                    }
                }
                // $originalFilename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = uniqid() . time();
                $newFilename = $safeFilename . '.' . $avatar->guessExtension();

                // Move the file to the directory where avatars are stored
                try {
                    $avatar->move(
                        $this->getParameter('avatar_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Erreur lors de l\'upload du fichier');
                }

                // updates the 'avatar' property to store
                $user->setAvatar($newFilename);
            } else {
                $user->setAvatar($currentAvatar);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Modifications effectuées avec succès.'
            );

            return $this->redirectToRoute('dashboard', [
                'slug' => $user->getSlug()
            ]);
        }

        return $this->render('user/update.html.twig', [
            'form'            => $form->createView()
        ]);
    }

    /**
     * @Route("/user/{id}/avatar-delete", name="user_avatar_delete", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function avatarDelete($id, User $user, EntityManagerInterface $em) {
        $currentUser = $this->getUser();

        if ($currentUser->getId() != $user->getId()) {
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas supprimer l\'avater d\'un autre utilisateur.'
            );

            return $this->redirectToRoute('home_page');
        }

        if (!empty($user->getAvatar())) {
            $fileToDelete = $this->getParameter('avatar_directory') . '/' . $user->getAvatar();
            if (file_exists($fileToDelete)) {
                // Suppression du fichier avatar
                unlink($fileToDelete);
            }

            // Suppresion de l'avatar en BDD
            $user->setAvatar(null);
            $em->flush();

            $this->addFlash(
                'success',
                'Confirmation suppression de votre avatar.'
            );
    
            return $this->redirectToRoute('dashboard', [
                'slug' => $user->getSlug()
            ]);
        }

        $this->addFlash(
            'danger',
            'Problème dans la suppression de l\'avatar.'
        );

        return $this->redirectToRoute('home_page');
    }
}
