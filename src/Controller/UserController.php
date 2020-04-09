<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Util\Captcha;
use App\Util\Slugger;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
     * @Route("/profil/{slug}", name="dashboard", methods={"GET"})
     * @ParamConverter("user", options={"mapping": {"slug": "slug"}})
     */
    public function dashboard(User $user)
    {
        return $this->render('user/dashboard.html.twig', [
            'user' => $user
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

            $slug = $slugger->sluggify($newUser->getUsername());

            // Vérification de la constraint d'unicité pour le slug
            $userRepo = $this->getDoctrine()->getRepository(User::class);
            $res = $userRepo->checkSlug($slug);

            if ($res) {
                $this->addFlash(
                    'danger',
                    'Identifiant déjà utilisé.'
                );

                return $this->redirectToRoute('sign_up');
            } else {
                $newUser->setSlug($slug);
            }

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

        // Je récupère l'ancien avatar
        $currentAvatar = $user->getAvatar();
        if (!empty($currentAvatar)) {
            $file = $this->getParameter('avatar_directory') . '/' . $currentAvatar;
            if (file_exists($file)) {
                $user->setAvatar(new File($this->getParameter('avatar_directory') . '/' . $currentAvatar));
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
                $slug = $slugger->sluggify($user->getUsername());

                // Vérification de la constraint d'unicité pour le slug
                $userRepo = $this->getDoctrine()->getRepository(User::class);
                $res = $userRepo->checkSlug($slug);

                if ($res) {
                    $this->addFlash(
                        'danger',
                        'Identifiant déjà utilisé.'
                    );

                    return $this->redirectToRoute('user_update', [
                        'id' => $user->getId()
                    ]);
                } else {
                    $user->setSlug($slug);
                }
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

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
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

                // Move the file to the directory where brochures are stored
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

            return $this->redirectToRoute('home_page');
        }

        return $this->render('user/update.html.twig', [
            'form'            => $form->createView()
        ]);
    }
}
