<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BookController extends AbstractController
{
    /**
     * @Route("/book/{slug}", name="book", methods={"GET", "POST"})
     * @ParamConverter("user", options={"mapping": {"slug": "slug"}})
     * 
     * @link https://ourcodeworld.com/articles/read/593/using-a-bootstrap-4-pagination-control-layout-with-knppaginatorbundle-in-symfony-3
     * @link https://github.com/KnpLabs/KnpPaginatorBundle
     */
    public function index($slug, User $user, BookRepository $bookRepo, Request $request, PaginatorInterface $paginator)
    {
        $books = $bookRepo->findBy([
            'user' => $user->getId()
        ], [
            'title' => 'ASC'
        ]);

        // $books = $bookRepo->findAllByCategory(intval($user->getId()));

        $books = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('book/index.html.twig', [
            'user' => $user,
            'slug' => $slug,
            'books' => $books
        ]);
    }

    /**
     * @Route("/book-search", name="book_search", methods={"GET", "POST"})
     * 
     * @link https://ourcodeworld.com/articles/read/593/using-a-bootstrap-4-pagination-control-layout-with-knppaginatorbundle-in-symfony-3
     * @link https://github.com/KnpLabs/KnpPaginatorBundle
     */
    public function bookSearch()
    {
        $response[] = [
            'id' => 1,
            'text' => 'texte 1'
        ];

        $response[] = [
            'id' => 1,
            'text' => 'texte 2'
        ];

        return $this->json($response);
    }
}
