<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        // Vérification que l'utilisateur est connecté en tant qu'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findBy([], [
                'order_z' => 'ASC',
                'name' => 'ASC'
            ]),
        ]);
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // Vérification que l'utilisateur est connecté en tant qu'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Catégorie créée.'
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Category $category): Response
    {
        // Vérification que l'utilisateur est connecté en tant qu'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Catégorie modifiée.'
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="category_delete", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function delete(Category $category, Request $request): Response
    {
        // Vérification que l'utilisateur est connecté en tant qu'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($category->getReference() == 'master') {
            $this->addFlash(
                'danger',
                'Catégorie "master" ne peut être supprimée.'
            );

            return $this->redirectToRoute('category_index');
        }

        $this->getDoctrine()->getRepository(Category::class)->categoryDelete(intval($category->getId()));

        $this->addFlash(
            'success',
            'Catégorie supprimée.'
        );

        return $this->redirectToRoute('category_index');
    }
}
