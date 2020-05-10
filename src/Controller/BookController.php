<?php

namespace App\Controller;

use App\Util\Image;
use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
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
        if (!$user->getPublic()) {
            // Vérification si utilisateur connecté
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

            $currentUser = $this->getUser();

            if ($user->getId() != $currentUser->getId() && $currentUser->getRole()->getCode() != 'ROLE_ADMIN') {
                $this->addFlash(
                    'danger',
                    'Le profil de cet utilisateur est privé.'
                );

                return $this->redirectToRoute('home_page');
            }
        }

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

        if ($order == 'DESC') {
            $order = [
                'title',
                'DESC'
            ];
        } elseif ($order == 'NOTEDESC') {
            $order = [
                'note',
                'DESC'
            ];
        } elseif ($order == 'NOTEASC') {
            $order = [
                'note',
                'ASC'
            ];
        } elseif ($order == 'CREATEDESC') {
            $order = [
                'created_at',
                'DESC'
            ];
        } elseif ($order == 'CREATEASC') {
            $order = [
                'created_at',
                'ASC'
            ];
        } else {
            // Dans tous les autres cas, affichage par ordre alphabétique des titres
            $order = [
                'title',
                'ASC'
            ];
        }

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
     * @Route("/book-search", name="book_search", methods={"POST"})
     */
    public function bookSearch(Request $request)
    {
        $request->isXmlHttpRequest();

        // Vérification si utilisateur connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $response = false;

        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $fr = $_POST['fr'];

            if (strlen($search) > 0) {
                $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($search) . '&country=FR&maxResults=10';

                if ($fr == 'true') {
                    $url .= '&langRestrict=fr';
                };
                // dump($url);

                // Requête JSON
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($output, 1);

                // dd($result);

                if (
                    is_array($result) && array_key_exists('totalItems', $result)
                    && $result['totalItems'] > 0 && array_key_exists('items', $result)
                ) {
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
     * @Route("/book/auto-new", name="book_auto_add", methods={"POST"})
     */
    public function bookAutoAdd(Request $request, BookRepository $bookRepository, CategoryRepository $categoryRepo, Image $imgService)
    {
        // is it an Ajax request ?
        if ($request->isXmlHttpRequest()) {

            // Vérification si utilisateur connecté
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
            // Récupération de l'utilisateur connecté
            $currentUser = $this->getUser();

            $book = new Book();
            $form = $this->createForm(BookType::class, $book, [
                'action' => $this->generateUrl('book_auto_add'),
                'attr' => [
                    'id' => 'book_info_form',
                ],
                'form_type' => 'auto'
            ]);

            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $reference = $book->getReference();

                if ($bookRepository->checkConstraint(intval($currentUser->getId()), $reference)) {
                    $response = [
                        'success' => false,
                        'message' => 'Livre déjà enregistré dans la bibliothèque'
                    ];

                    return $this->json($response);
                }

                $image = $book->getImage();
                $file = (!is_null($image) ? $imgService->createFileImage($image, $reference) : null);
                $book->setFile($file);
                $book->setUser($currentUser);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($book);
                $entityManager->flush();


                return $this->json([
                    'success' => true,
                    'message' => 'Enregistrement réussi'
                ]);
            } else {
        
                return $this->json([
                    'success' => false,
                    'form' => $this->renderView('book/_add_form.html.twig', ['form' => $form->createView()])
                ]);
            }
        }
    }

    /**
     * @Route("/book/manual-new", name="book_manual_add", methods={"POST"})
     */
    public function bookManualAdd(Request $request, BookRepository $bookRepository, CategoryRepository $categoryRepo, Image $imgService)
    {
        // is it an Ajax request ?
        if ($request->isXmlHttpRequest()) {

            // Vérification si utilisateur connecté
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
            // Récupération de l'utilisateur connecté
            $currentUser = $this->getUser();

            $book = new Book();
            $form = $this->createForm(BookType::class, $book, [
                'action' => $this->generateUrl('book_manual_add'),
                'attr' => [
                    'id' => 'book_info_form',
                ],
                'form_type' => 'manual'
            ]);

            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $book->setUser($currentUser);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($book);
                $entityManager->flush();

                return $this->json([
                    'success' => true,
                    'message' => 'Enregistrement réussi'
                ]);
            } else {
        
                return $this->json([
                    'success' => false,
                    'form' => $this->renderView('book/_add_form.html.twig', ['form' => $form->createView()])
                ]);
            }
        }
    }

    /**
     * @Route("/book/{id}/update", name="book_update", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function update($id, Book $book, Request $request, CategoryRepository $categoryRepo)
    {
        // is it an Ajax request ?
        if ($request->isXmlHttpRequest()) {
            // Vérification si utilisateur connecté
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
            // Récupération de l'utilisateur connecté
            $currentUser = $this->getUser();

            if ($currentUser->getId() != $book->getUser()->getId()) {
                return $this->json([
                    'success' => false,
                    'message' => 'Modifications des données d\'un tiers interdites'
                ]);
            }

            $form = $this->createForm(BookType::class, $book, [
                'action' => $this->generateUrl('book_update', [
                    'id' => $id
                ]),
                'attr' => [
                    'id' => 'book_update_form',
                ],
                'form_type' => 'update'
            ]);

            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($book);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Modifications effectuées.'
                );

                return $this->json([
                    'success' => true,
                    'message' => 'Modifications effectuées'
                ]);
            } else {
        
                return $this->json([
                    'success' => false,
                    'form' => $this->renderView('book/_update_form.html.twig', ['form' => $form->createView()])
                ]);
            }
        }
    }

    /**
     * @Route("/book/{id}/delete", name="book_delete", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function delete($id, Book $book, EntityManagerInterface $em, BookRepository $bookRepo)
    {
        // Vérification si utilisateur connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        // Récupération de l'utilisateur connecté
        $currentUser = $this->getUser();

        if ($book->getUser()->getId() != $currentUser->getId()) {
            $this->addFlash(
                'danger',
                'Vous ne pouvez pas modifier/supprimer les informations d\'un tiers.'
            );

            return $this->redirectToRoute('home_page');
        }

        $currentFile = $book->getFile();
        $checkFile = $bookRepo->checkFile($currentFile);

        // Suppression du livre
        $em->remove($book);
        $em->flush();

        // Après suppression du book, on vérifie s'il faut supprimer l'image associée
        // Dans le cas où plus aucun book n'a l'image correspondante
        if ($currentFile) {
            $checkFile = $bookRepo->checkFile($currentFile);

            // Si plus aucun livre n'a le fichier image associé,
            // on supprime physiquement le fichier concerné
            if (!$checkFile) {
                $fileToDelete = $this->getParameter('book_directory') . '/' . $currentFile;
                // dd($fileToDelete);
                @unlink($fileToDelete);
            }
        }

        $this->addFlash(
            'success',
            'Livre supprimé de la bibliothèque.'
        );

        return $this->redirectToRoute('book_list', [
            'slug' => $currentUser->getSlug()
        ]);
    }
}
