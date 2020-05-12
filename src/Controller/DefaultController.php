<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Util\Book;
use App\Util\Captcha;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email AS EmailMime;
use Symfony\Component\Routing\Annotation\Route;
use App\Validator\Constraints\CaptchaConstraint;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @link https://symfony.com/doc/current/mailer.html
     * 
     * @Route("/", name="home_page", methods={"GET", "POST"})
     */
    public function homePage(Request $request, PostRepository $postRepository)
    {
        $preStarBook = Book::BOOK;
        shuffle($preStarBook);

        $starBook = array();
        $maxI = 6;
        for ($i = 0; $i < $maxI; $i++) {
            $starBook[] = $preStarBook[$i];
        }

        // Récupération des articles associés à la page d'accueil
        $posts1 = $postRepository->findBy([
            'topic' => 'index1'
        ], [
            'order_z' => 'ASC',
            'title' => 'ASC'
        ]);
        $posts2 = $postRepository->findBy([
            'topic' => 'index2'
        ], [
            'order_z' => 'ASC',
            'title' => 'ASC'
        ]);

        return $this->render('default/index.html.twig', [
            'star_book'      => $starBook,
            'posts1' => $posts1,
            'posts2' => $posts2
        ]);
    }

    /**
     * @link https://symfony.com/doc/current/mailer.html
     * 
     * @Route("/contact", name="contact", methods={"POST"})
     */
    public function contact(Request $request, PostRepository $postRepository, MailerInterface $mailer, Captcha $captcha)
    {
        // is it an Ajax request ?
        if ($request->isXmlHttpRequest()) {
            $contactForm = $this->createContactForm();
            $contactForm->handleRequest($request);
    
            if ($contactForm->isSubmitted() && $contactForm->isValid()) {
                $data = $contactForm->getData();
                $email = (new EmailMime())
                ->from(new Address($this->getParameter('website_email'), $this->getParameter('website_title')))
                ->to($this->getParameter('webmaster_email'))
                ->replyTo($data['email'])
                ->subject($this->getParameter('website_title') . ' - ' . $data['object'])
                ->text($data['body'])
                ->html('<p>' . nl2br($data['body']) . '</p>');
    
                $mailer->send($email);
    
                return $this->json([
                    'success' => true,
                    'message' => 'Message envoyé avec succès.',
                    'form' => null
                ]);
            } else {
                return $this->json([
                    'success' => false,
                    'form' => $this->renderView('default/_contact_form.html.twig', [
                        'contact_form' => $contactForm->createView(),
                        'captcha' => $captcha->createCaptcha()
                    ])
                ]);
            }
        }
    }

    /**
     * @Route("/mentions-legales", name="legal_notice", methods={"GET"})
     */
    public function legalNotice(PostRepository $postRepository)
    {
        // Récupération des articles associés aux mentions légales
        $posts = $postRepository->findBy([
            'topic' => 'mentions_legales'
        ], [
            'order_z' => 'ASC',
            'title' => 'ASC'
        ]);

        return $this->render('default/legal-notice.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/faq", name="faq", methods={"GET"})
     */
    public function faq(PostRepository $postRepository)
    {
        // Récupération des articles associés aux FAQ
        $posts = $postRepository->findBy([
            'topic' => 'faq'
        ], [
            'order_z' => 'ASC',
            'title' => 'ASC'
        ]);

        return $this->render('default/faq.html.twig', [
            'posts' => $posts
        ]);
    }

    private function createContactForm() {

        // https://symfony.com/doc/current/form/without_class.html
        $form = $this->createFormBuilder(null)
        ->setAction($this->generateUrl('contact'))
        ->add('email', EmailType::class, [
            'label' => 'Votre adresse email (*)',
            'attr' => [
                'placeholder' => 'email'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner votre adresse email.'
                ]),
                new Email([
                    'mode' => 'loose',
                    'message' => 'L\'adresse email saisie n\'est pas valide.'
                ])
            ]
        ])
        ->add('object', ChoiceType::class, [
            'label' => 'Sujet (*)',
            'required' => true,
            'choices' => [
                'Contact (divers)' => 'contact',
                'Demande de partenariat' => 'partenariat',
                'Demande de suppression (ou désactivation) de compte' => 'suppression',
                'Incident technique ou suggestion' => 'incident'
            ],
            'expanded' => false,
            'multiple' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez sélectionner un sujet.',
                ])
            ]
        ])
        ->add('body', TextareaType::class, [
            'label' => 'Votre message (*)',
            'attr' => [
                'rows' => 7,
                'placeholder' => 'Message'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un message.',
                ])
            ]
        ])
        ->add('captcha', IntegerType::class, [
            'label' => 'Renseignez les 4 chiffres présents dans l\'image (*)',
            'attr' => [
                'placeholder' => '????'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Saissisez le nombre affiché dans l\'image.'
                ]),
                new Length([
                    'min'        => 4,
                    'max'        => 4,
                    'minMessage' => 'Nombre de caractères minimum attendus : {{ limit }}',
                    'maxMessage' => 'Nombre de caractères maximum attendus : {{ limit }}'
                ]),
                new CaptchaConstraint([
                    // 'message' => 'test' // Pas besoin dans ce cas, car le message d'erreur
                    // est déjà écrit dans la class CaptchaConstraint
                ])
            ]
        ])
        ->getForm();

        return $form;
    }
}
