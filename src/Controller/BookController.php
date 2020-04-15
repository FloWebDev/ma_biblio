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

        $response = false;

        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $fr = $_POST['fr'];

            if (strlen($search) > 0) {
                $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($search) . '&maxResults=10';

                if ($fr == 'true') {
                    $url .= '&langRestrict=fr';
                };

                // Requête JSON
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($output, 1);

                // dd($result);

                if (is_array($result) && array_key_exists('totalItems', $result) && $result['totalItems'] > 0) {
                    foreach ($result['items'] as $index => $book) {
                        // dd($book['imageLinks']['thumbnail']);
                        // dump($result['items'][$index]['volumeInfo']['imageLinks']['thumbnail']);

                        if (isset($book['volumeInfo'])) {
                        

                            $id = $book['id'];
                            $info = $book['volumeInfo'];
                            // dd($info['categories']);
                            $title = (isset($info['title']) ? $info['title'] : null);
                            // $authorTitle = (isset($info['authors']) ? (' - ' . $info['authors'][0]) : null);

                            if (isset($info['industryIdentifiers']) && count($info['industryIdentifiers']) >= 2) {
                                $isbn13 = ($info['industryIdentifiers'][0]['type'] == 'ISBN_13' ? $info['industryIdentifiers'][0]['identifier'] : null);
                                $isbn10 = ($info['industryIdentifiers'][1]['type'] == 'ISBN_10' ? $info['industryIdentifiers'][1]['identifier'] : null);
                            } else {
                                $isbn13 = null;
                                $isbn10 = null;
                            }

                            $response[] = [
                                'id' => $id,
                                'text' => ((isset($info['authors']) && is_array($info['authors'])) ? ($title . ' - ' . implode(', ', $info['authors'])) : $info['title']),
                                'title' => (isset($info['title']) ? $info['title'] : null),
                                'subtitle' => (!empty($info['subtitle']) ? $info['subtitle'] : null),
                                'author' => ((isset($info['authors']) && is_array($info['authors'])) ? implode(', ', $info['authors']) : null),
                                'published_date' => (!empty($info['publishedDate']) ? $info['publishedDate'] : null),
                                'description' => (!empty($info['description']) ? $info['description'] : null),
                                'isbn_13' => (!empty($isbn13) ? $isbn13 : null),
                                'isbn_10' => (!empty($isbn10) ? $isbn10 : null),
                                'image' => ((!empty($info['imageLinks']) && !empty($info['imageLinks']['thumbnail'])) ? $info['imageLinks']['thumbnail'] : null),
                                'litteral_category' => ((!empty($info['categories']) && is_array($info['categories'])) ? implode(', ', $info['categories']) : null)
                            ];
                        } else {
                            $response = false;
                        }
                    }
                    unset($book);
                } else {
                    $response = false;
                }
            }
        }

        return $this->json($response);
    }
}
