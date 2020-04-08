<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home_page", methods={"GET"})
     */
    public function homePage()
    {
        $bookReadList = [
            '1984 - George Orwell',
            'Le Seigneur des anneaux - Intégrale - J.R.R. Tolkien',
            'L\'Étranger - Albert Camus',
            'Voyage au bout de la nuit - Louis-Ferdinand Céline',
            'Les Fleurs du mal - Charles Baudelaire',
            'Le Petit Prince - Antoine de Saint-Exupéry',
            'La Horde du Contrevent - Alain Damasio',
            'L\'Écume des jours - Boris Vian',
            'Harry Potter à l\'école des sorciers - J. K. Rowling',
            'Dune - Le Cycle de Dune, tome 1 - Frank Herbert',

        ];

        $bookNoteList = [
            'Le Parfum - Patrick Süskind',
            'Fondation - Le Cycle de Fondation, tome 1 - Oscar Wilde',
            'La Nuit des temps - René Barjavel',
            'Crime et Châtiment - Fiodor Dostoïevski',
            'Orgueil et Préjugés - Jane Austen',
            'Les Liaisons dangereuses - Choderlos de Laclos',
            'Cyrano de Bergerac - Edmond Rostand',
            'Harry Potter et les Reliques de la Mort - Harry Potter, tome 7 - J. K. Rowling',
            'L\'Attrape-cœurs - J. D. Salinger',
            'Dix petits Nègres - Agatha Christie',
            // 'Le Meilleur des mondes - Aldous Huxley',
            // 'Cent ans de solitude - Gabriel García Márquez',
            // 'Lolita - Vladimir Nabokov',
            // 'Des souris et des hommes - John Steinbeck',
            // 'Les Frères Karamazov - Fiodor Dostoïevski',
            // 'Le Comte de Monte-Cristo - Alexandre Dumas',
            // 'L\'Insoutenable Légèreté de l\'être - Milan Kundera',
            // 'La Ferme des animaux - George Orwell',
            // 'Ubik - Philip K. Dick',
            // 'Bilbo le Hobbit - J.R.R. Tolkien'
        ];

        return $this->render('default/index.html.twig', [
            'website_title'  => '<i class="fas fa-book"></i>  Bookstore',
            'book_read_list' => $bookReadList,
            'book_note_list' => $bookNoteList
        ]);
    }

    /**
     * @Route("/mentions-legales", name="legal_notice", methods={"GET"})
     */
    public function legalNotice()
    {
        return $this->render('default/legal-notice.html.twig', [

        ]);
    }

    /**
     * @Route("/cgu", name="terms_of_service", methods={"GET"})
     */
    public function cgu()
    {
        return $this->render('default/terms-of-service.html.twig', [
        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function contact()
    {
        return $this->render('default/contact.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
