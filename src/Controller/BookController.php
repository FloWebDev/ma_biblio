<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BookController extends AbstractController
{
    /**
     * @Route("/books/{slug}", name="book_list", methods={"GET", "POST"})
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
                $category = intval($category);
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
            'categories' => $categories,
            'notes' => $this->notes()
        ]);
    }

    /**
     * @Route("/book-search", name="book_search", methods={"POST"})
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

                if (is_array($result) && array_key_exists('totalItems', $result) 
                && $result['totalItems'] > 0 && array_key_exists('items', $result)) {
                    $response = array();
                    foreach ($result['items'] as $book) {

                        if (isset($book['volumeInfo'])) {
                            $id = $book['id'];
                            $info = $book['volumeInfo'];
                            $title = (isset($info['title']) ? $info['title'] : null);

                            if (isset($info['industryIdentifiers']) && count($info['industryIdentifiers']) >= 2) {
                                $isbn13 = ($info['industryIdentifiers'][0]['type'] == 'ISBN_13' ? $info['industryIdentifiers'][0]['identifier'] : null);
                                $isbn10 = ($info['industryIdentifiers'][1]['type'] == 'ISBN_10' ? $info['industryIdentifiers'][1]['identifier'] : null);
                            } else {
                                $isbn13 = null;
                                $isbn10 = null;
                            }

                            // Formatage des données pour chaque livre associé à la recherche
                            $response[] = [
                                'id' => $id,
                                'text' => ((isset($info['authors']) && is_array($info['authors'])) ? ($title . ' - ' . implode(', ', $info['authors'])) : $info['title']),
                                'reference' => $id,
                                'title' => $title,
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

    /**
     * @Route("/book/new", name="book_add", methods={"POST"})
     * 
     * @link https://ourcodeworld.com/articles/read/593/using-a-bootstrap-4-pagination-control-layout-with-knppaginatorbundle-in-symfony-3
     * @link https://github.com/KnpLabs/KnpPaginatorBundle
     */
    public function bookAdd(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepo) {
        $request->isXmlHttpRequest();

        // Vérification si utilisateur connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // Récupération de l'utilisateur connecté
        $currentUser = $this->getUser();

        // dd($request->request);

        if (!empty($request->request->get('reference'))) {
            $reference = $request->request->get('reference');
            $title = (!empty($request->request->get('title')) ? $request->request->get('title') : 'N.C.');
            $subtitle = (!empty($request->request->get('subtitle')) ? $request->request->get('subtitle') : null);
            $author = (!empty($request->request->get('author')) ? $request->request->get('author') : null);
            $published_date = (!empty($request->request->get('published_date')) ? $request->request->get('published_date') : null);
            $description = (!empty($request->request->get('description')) ? $request->request->get('description') : null);
            $litteral_category = (!empty($request->request->get('litteral_category')) ? $request->request->get('litteral_category') : null);
            $isbn_13 = (!empty($request->request->get('isbn_13')) ? $request->request->get('isbn_13') : null);
            $isbn_10 = (!empty($request->request->get('isbn_10')) ? $request->request->get('isbn_10') : null);
            $image = (!empty($request->request->get('image')) ? $request->request->get('image') : null);
            $comment = (!empty($request->request->get('comment')) ? $request->request->get('comment') : null);
            // Traitement particulier pour la note
            $note = (!empty($request->request->get('note')) ? $request->request->get('note') : null);
            if (is_null($note)) {
                $note = null;
            } else {
                $note = intval($request->request->get('note'));
                // On vérifie que la note est incluse dans la liste des notes possibles
                // Sinon, on sette à "null" sa valeur
                if (!in_array($note, $this->notes())) {
                    $note = null;
                }
            }
            // Traitement particulier pour la catégorie
            $category_id = (!empty($request->request->get('category')) ? intval($request->request->get('category')) : null);
            if(!is_null($category_id)) {
                $category = $categoryRepo->find($category_id);
            } else {
                $category = null;
            }

            $newBook = new Book();
            $newBook->setReference($reference);
            $newBook->setTitle($title);
            $newBook->setSubtitle($subtitle);
            $newBook->setAuthor($author);
            $newBook->setPublishedDate($published_date);
            $newBook->setDescription($description);
            $newBook->setLitteralCategory($litteral_category);
            $newBook->setIsbn13($isbn_13);
            $newBook->setIsbn10($isbn_10);
            $newBook->setImage($image);
            $newBook->setUser($currentUser);
            $newBook->setCategory($category);
            $newBook->setNote($note);
            $newBook->setComment($comment);
            
            $em->persist($newBook);
            $em->flush();

            $response = [
                'success' => true,
                'message' => 'Enregistrement réussi'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Echec de l\'enregistrement'
            ];
        }

        return $this->json($response);
    }

    /**
     * Permet d'obtenir un array de toutes les valeurs autorisées
     * pour la note d'un livre
     * 
     * @return array
     */
    private function notes() {
        $notes = array();
        for($n = 0; $n <= 20; $n++) {
            $notes[] = $n;
        }
        return $notes;
    }
}
