<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Util\Captcha;
use App\Util\Slugger;
use App\Form\UserType;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/profil/{slug}", name="dashboard", methods={"GET", "POST"})
     * @ParamConverter("user", options={"mapping": {"slug": "slug"}})
     */
    public function dashboard(User $user, UserRepository $userRepo, BookRepository $bookRepo, Request $request)
    {
        // Récupération des informations de l'utilisateur ("null" si user non connecté)
        $currentUser = $this->getUser();

        if (!$user->getPublic()) {
            // Vérification si utilisateur connecté
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            if ($user->getId() != $currentUser->getId() && $currentUser->getRole()->getCode() != 'ROLE_ADMIN') {
                $this->addFlash(
                    'danger',
                    'Le profil de cet utilisateur est privé.'
                );

                return $this->redirectToRoute('home_page');
            }
        }
        /**
         * Création du formulaire avatar
         * 
         * @link https://symfony.com/doc/current/form/without_class.html
         */
        $avatarForm = $this->createFormBuilder(null)
            ->add('avatar', FileType::class, [
                'label' => 'Avatar / photo de profil (PNG, JPEG)',
                'attr' => [],
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
                        @unlink($fileToDelete);
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

        $books = $bookRepo->getBookByCategoryAndUser(intval($user->getId()));
        $bookMoyenne = $bookRepo->getAverageNote(intval($user->getId()));
        $bestBooks = $bookRepo->findBy([
            'user' => $user->getId()
        ], [
            'note' => 'DESC',
            'created_at' => 'DESC'
        ], 7);

        // Informations pour compte Administrateur seulement
        $userNumber = null;
        $countBook = null;
        if (
            $currentUser && $currentUser->getRole()->getCode() == 'ROLE_ADMIN'
            && $currentUser->getId() == $user->getId()
        ) {
            // On exécute les méthodes uniquement si l'utilisateur connecté est admin
            // et présent sur sa propre page de profil (dashboard)
            $userNumber = $userRepo->userCount();
            $countBook = $bookRepo->getBookCount();
        }


        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
            // 'ref' => md5($user->getCreatedAt()->format('Y-m-d H:i:s')) . 'H1717' . $user->getId(),
            'books' => $books,
            'bestBooks' => $bestBooks,
            'average_note' => (!empty($bookMoyenne) ? round($bookMoyenne) : 0),
            'avatar_form' => $avatarForm->createView(),
            'userNb' => $userNumber,
            'countBook' => $countBook
        ]);
    }

    /**
     * @Route("/users", name="user_list", methods={"GET"})
     */
    public function getUsers(UserRepository $userRepo, Request $request, PaginatorInterface $paginator)
    {
        $search = (!empty($request->query->get('s')) ? $request->query->get('s') : null);
        if (is_null($search)) {
            $users = $userRepo->findBy(['public' => true], [
                'slug' => 'ASC'
            ]);
        } else {
            $users = $userRepo->findUsersBySearch($search);
            if (is_array($users) && count($users) > 0) {
                $this->addFlash(
                    'success',
                    count($users) . ' résultats trouvés.'
                );
            } else {
                $this->addFlash(
                    'warning',
                    'Aucun résultat trouvé'
                );
            }
        }

        $users = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('user/users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/inscription", name="sign_up", methods={"GET", "POST"})
     */
    public function signUp(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, Slugger $slugger, Captcha $captcha)
    {
        // On bloque l'accès à cette page si utilisateur connecté
        if ($this->getUser()) {
            return $this->redirectToRoute('home_page');
        }

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
    public function update($id, User $user, Request $request, UserPasswordEncoderInterface $encoder, Slugger $slugger)
    {
        // Vérification si utilisateur connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currentUser = $this->getUser();

        if ($currentUser->getId() != $user->getId() && $currentUser->getRole()->getCode() != 'ROLE_ADMIN') {
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas modifier/supprimer les informations d\'un tiers.'
            );

            return $this->redirectToRoute('home_page');
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
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/{id}/avatar-delete", name="user_avatar_delete", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function avatarDelete($id, User $user, EntityManagerInterface $em)
    {
        // Vérification si utilisateur connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Récupération des informations de l'utilisateur connecté
        $currentUser = $this->getUser();

        if ($currentUser->getId() != $user->getId() && $currentUser->getRole()->getCode() != 'ROLE_ADMIN') {
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas modifier/supprimer les informations d\'un tiers.'
            );

            return $this->redirectToRoute('home_page');
        }

        if (!empty($user->getAvatar())) {
            $fileToDelete = $this->getParameter('avatar_directory') . '/' . $user->getAvatar();
            if (file_exists($fileToDelete)) {
                // Suppression du fichier avatar
                @unlink($fileToDelete);
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

    /**
     * @Route("/user/{id}/delete", name="user_delete", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function delete($id, User $user, UserRepository $userRepository, BookRepository $bookRepo)
    {
        // Vérification si utilisateur connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $currentUser = $this->getUser();

        if (
            $user->getRole()->getCode() == 'ROLE_ADMIN' ||
            ($currentUser->getId() != $user->getId() && $currentUser->getRole()->getCode() != 'ROLE_ADMIN')
        ) {
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas modifier/supprimer les informations d\'un tiers.'
            );

            return $this->redirectToRoute('home_page');
        }

        $books = $user->getBooks();
        $booksToDelete = array();

        if (!$books->isEmpty()) {
            foreach ($books as $book) {
                $booksToDelete[] = $book->getFile();
            }
            unset($book);
        }

        $result = $userRepository->allDelete(intval($user->getId()));

        if (count($booksToDelete) > 0) {
            foreach ($booksToDelete as $currentFile) {
                $checkFile = $bookRepo->checkFile($currentFile);

                // Si plus aucun livre n'a le fichier image associé,
                // on supprime physiquement le fichier concerné
                if (!$checkFile) {
                    $fileToDelete = $this->getParameter('book_directory') . '/' . $currentFile;
                    // dd($fileToDelete);
                    @unlink($fileToDelete);
                }
            }
            unset($currentFile);
        }

        if ($result) {
            $this->addFlash(
                'success',
                'Suppression données et compte utilisateur.'
            );
        } else {
            $this->addFlash(
                'danger',
                'Problème suppression utilisateur.'
            );
        }

        return $this->redirectToRoute('admin_users');
    }
}
