<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    /**
     * @Route("/book/{slug}", name="book", methods={"GET", "POST"})
     * @ParamConverter("user", options={"mapping": {"slug": "slug"}})
     */
    public function index($slug, User $user, BookRepository $bookRepo)
    {
        $books = $bookRepo->findBy([
            'user' => $user->getId()
        ], [
            'title' => 'ASC'
        ]);

        return $this->render('book/index.html.twig', [
            'user' => $user,
            'slug' => $slug,
            'books' => $books
        ]);
    }
}
