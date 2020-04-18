<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function getUsers(UserRepository $userRepository, Request $request, PaginatorInterface $paginator)
    {
        $users = $userRepository->findBy([], [
            'slug' => 'ASC'
        ]);

        $users = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }
}
