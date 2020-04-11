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
        $preStarBook = [
            [
                'title' => '1984',
                'img' => '1984.jpg',
                'description' => 'Année 1984 en Océanie. 1984 ? C’est en tout cas ce qu’il semble à Winston, qui ne saurait toutefois en jurer. Le passé a été oblitéré et réinventé, et les événements les plus récents sont susceptibles d’être modifiés. Winston est lui-même chargé de récrire les archives qui contredisent le présent et les promesses de Big Brother. Grâce à une technologie de pointe, ce dernier sait tout, voit tout. Il n’est pas une âme dont il ne puisse connaître les pensées. On ne peut se fier à personne et les enfants sont encore les meilleurs espions qui soient. Liberté est Servitude. Ignorance est Puissance. Telles sont les devises du régime de Big Brother. La plupart des Océaniens n’y voient guère à redire, surtout les plus jeunes qui n’ont pas connu l’époque de leurs grands-parents et le sens initial du mot "libre". Winston refuse cependant de perdre espoir. Il entame une liaison secrète et hautement dangereuse avec l’insoumise Julia et tous deux vont tenter d’intégrer la Fraternité, une organisation ayant pour but de renverser Big Brother. Mais celui-ci veille…</p>

                <p>Le célèbre et glaçant roman de George Orwell se redécouvre dans une nouvelle traduction, plus directe et plus dépouillée, qui tente de restituer la terreur dans toute son immédiateté mais aussi les tonalités nostalgiques et les échappées lyriques d’une œuvre brutale et subtile, équivoque et génialement manipulatrice.'
            ],
            [
                'title' => 'L\'étranger',
                'img' => 'l-etranger.jpg',
                'description' => '"Quand la sonnerie a encore retenti, que la porte du box s\'est ouverte, c\'est le silence de la salle qui est monté vers moi, le silence, et cette singulière sensation que j\'ai eue lorsque j\'ai constaté que le jeune journaliste avait détourné les yeux. Je n\'ai pas regardé du côté de Marie. Je n\'en ai pas eu le temps parce que le président m\'a dit dans une forme bizarre que j\'aurais la tête tranchée sur une place publique au nom du peuple français..."'
            ],
            [
                'title' => 'Le tour du monde en 80 jours',
                'img' => 'le-tour-du-monde-en-80-jours.jpg',
                'description' => 'En 1872, un riche gentleman londonien, Phileas Fogg, parie vingt mille livres qu\'il fera le tour du monde en quatre-vingts jours. Accompagné de son valet de chambre, le dévoué Passepartout, il quitte Londres pour une formidable course contre la montre. Au prix de mille aventures, notre héros va s\'employer à gagner ce pari.'
            ],
            [
                'title' => 'Harry Potter à l\'école des sorciers',
                'img' => 'harry-potter.jpeg',
                'description' => 'Le jour de ses onze ans, la vie de Harry Potter est bouleversée à jamais quand Rubeus Hagrid, un géant aux yeux brillants comme des scarabées, lui apporte une lettre ainsi que d\'incroyables nouvelles. Harry Potter n\'est pas un garçon comme les autres : c\'est un sorcier. Et une aventure extraordinaire est sur le point de commencer.'
            ],
            [
                'title' => 'Autre Monde - L\'alliance des trois (T1)',
                'img' => 'autre-monde.jpg',
                'description' => 'Personne ne l\'a vue venir.La Grande Tempête : un ouragan de vent et de neige qui plonge le pays dans l\'obscurité et l\'effroi.D\'étranges éclairs bleus rampent le long des immeubles, les palpent, à la recherche de leurs proies ... Quand les enfants se sont éveillés, la Terre n\'était plus la même. Désormais seuls, ils vont devoir s\'organiser. Pour comprendre. Pour survivre. À cet Autre-Monde.Après Le Seigneur des anneaux, La Croisée des mondes, Harry Potter ..., la naissance d\'un nouvel univers : Autre-Monde. Entre roman d\'aventure et fantasy, une série totalement originale que les adultes aimeront faire découvrir aux plus jeunes.'
            ],
            [
                'title' => 'Ravage',
                'img' => 'ravage.jpg',
                'description' => '«- Vous ne savez pas ce qui est arrivé ? Tous les moteurs d\'avions se sont arrêtés hier à la même heure, juste au moment où le courant flanchait partout. Tous ceux qui s\'étaient mis en descente pour atterrir sur la terrasse sont tombés comme une grêle. Vous n\'avez rien entendu, là-dessous ? Moi, dans mon petit appartement près du garage, c\'est bien un miracle si je n\'ai pas été aplati. Quand le bus de la ligne 2 est tombé, j\'ai sauté au plafond comme une crêpe... Allez donc jeter un coup d\'œil dehors, vous verrez le beau travail !»'
            ],
        ];

        shuffle($preStarBook);

        $starBook = array();
        for ($i = 0; $i < 6; $i++) {
            $starBook[] = $preStarBook[$i];
        }

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
            'star_book'      => $starBook,
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
