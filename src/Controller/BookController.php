<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
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
    public function index($slug, User $user, BookRepository $bookRepo, CategoryRepository $categoryRepo, Request $request, PaginatorInterface $paginator)
    {
        // Gestion de la liste des livres à afficher en fonction des filtres et ordres choisis
        $category = $request->query->get('category');
        $order = $request->query->get('order');

        if (!is_null($category)) {
            if ($category == 'all') {
                $category = null;
            } else {
                $category = filter_var($category, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            }
        }

        $order = (!is_null($order) ? filter_var($order, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : 'ASC');

        $books = $bookRepo->getBookList(intval($user->getId()), $category, $order);

        // Récupération de toutes les catégories
        $categories = $categoryRepo->findBy([], [
            'order_z' => 'ASC'
        ]);

        // Pagination des livres
        $books = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('book/index.html.twig', [
            'user' => $user,
            'slug' => $slug,
            'books' => $books,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/book-search", name="book_search", methods={"GET", "POST"})
     * 
     * @link https://ourcodeworld.com/articles/read/593/using-a-bootstrap-4-pagination-control-layout-with-knppaginatorbundle-in-symfony-3
     * @link https://github.com/KnpLabs/KnpPaginatorBundle
     */
    public function bookSearch(Request $request)
    {
        $request->isXmlHttpRequest();

        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            if (strlen($search) > 0) {
                // TODO PHP CURL
            }
        }

        // if ()
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
