<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use Symfony\Component\Form\FormEvent;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listener = function (FormEvent $event) {
            $form = $event->getForm();
            $form_type = $event->getForm()->getConfig()->getOptions()['form_type'];

            if ($form_type == 'auto') {
                // Formulaire auto-complété
                $form->add('title', TextType::class, [
                    'label' => 'Titre',
                    'empty_data' => 'N.C.',
                    'attr' => [
                        'readonly' => 'readonly',
                    ],
                    'constraints' => [
                        new Length([
                            'max' => 250,
                            'maxMessage' => 'Maximum {{ limit }} caractères.',
                        ])
                    ]
                ])
                ->add('subtitle', HiddenType::class)
                ->add('author', TextType::class, [
                    'label' => 'Auteur(s)',
                    'attr' => [
                        'readonly' => 'readonly',
                    ],
                    'constraints' => [
                        new Length([
                            'max' => 250,
                            'maxMessage' => 'Maximum {{ limit }} caractères.',
                        ])
                    ]
                ])
                ->add('published_date', TextType::class, [
                    'label' => 'Date de publication',
                    'attr' => [
                        'readonly' => 'readonly',
                    ],
                    'constraints' => [
                        new Length([
                            'max' => 32,
                            'maxMessage' => 'Maximum {{ limit }} caractères.',
                        ])
                    ]
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Résumé',
                    'attr' => [
                        'readonly' => 'readonly',
                        'rows' => 7
                    ]
                ])
                ->add('isbn_13', HiddenType::class)
                ->add('isbn_10', HiddenType::class)
                ->add('image', HiddenType::class)
                ->add('litteral_category', TextType::class, [
                    'label' => 'Genre',
                    'attr' => [
                        'readonly' => 'readonly',
                    ],
                    'constraints' => [
                        new Length([
                            'max' => 250,
                            'maxMessage' => 'Maximum {{ limit }} caractères.',
                        ])
                    ]
                ]);
            } elseif ($form_type == 'manual') {
                // Formulaire saisie manuelle
                $form
                ->add('title', TextType::class, [
                    'label' => 'Titre (*)',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Champ obligatoire'
                        ]),
                        new Length([
                            'min' => 3,
                            'minMessage' => 'Minimum {{ limit }} caractères.',
                            'max' => 250,
                            'maxMessage' => 'Maximum {{ limit }} caractères.',
                        ])
                    ]
                ])
                ->add('subtitle', HiddenType::class)
                ->add('author', TextType::class, [
                    'label' => 'Auteur(s)',
                    'constraints' => [
                        new Length([
                            'max' => 250,
                            'maxMessage' => 'Maximum {{ limit }} caractères.',
                        ])
                    ]
                ])
                ->add('published_date', TextType::class, [
                    'label' => 'Date de publication',
                    'constraints' => [
                        new Length([
                            'max' => 32,
                            'maxMessage' => 'Maximum {{ limit }} caractères.',
                        ])
                    ]
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Résumé',
                    'attr' => [
                        'rows' => 7
                    ]
                ])
                ->add('isbn_13', HiddenType::class)
                ->add('isbn_10', HiddenType::class)
                ->add('image', HiddenType::class)
                ->add('litteral_category', ChoiceType::class, [
                    'label' => 'Genre',
                    'choices' => [
                        'Aucun' => null,
                        'Actu, Politique et Société' => 'Actu, Politique et Société',
                        'Adolescents' => 'Adolescents',
                        'Art, Musique et Cinéma' => 'Art, Musique et Cinéma',
                        'Bandes dessinées' => 'Bandes dessinées',
                        'Beaux livres' => 'Beaux livres',
                        'Cuisine et Vins' => 'Cuisine et Vins',
                        'Dictionnaires, langues et encyclopédies' => 'Dictionnaires, langues et encyclopédies',
                        'Droit' => 'Droit',
                        'Entreprise et Bourse' => 'Entreprise et Bourse',
                        'Érotisme' => 'Érotisme',
                        'Etudes supérieures' => 'Etudes supérieures',
                        'Famille et bien-être' => 'Famille et bien-être',
                        'Fantasy et Terreur' => 'Fantasy et Terreur',
                        'Histoire' => 'Histoire',
                        'Humour' => 'Humour',
                        'Informatique et Internet' => 'Informatique et Internet',
                        'Livres pour enfants' => 'Livres pour enfants',
                        'Loisirs créatifs, décoration et passions' => 'Loisirs créatifs, décoration et passions',
                        'Manga' => 'Manga',
                        'Nature et animaux' => 'Nature et animaux',
                        'Religions et Spiritualités' => 'Religions et Spiritualités',
                        'Romance et littérature sentimentale' => 'Romance et littérature sentimentale',
                        'Romans et littérature' => 'Romans et littérature',
                        'Romans policiers et polars' => 'Romans policiers et polars',
                        'Santé, Forme et Diététique' => 'Santé, Forme et Diététique',
                        'Science-Fiction' => 'Science-Fiction',
                        'Sciences, Techniques et Médecine' => 'Sciences, Techniques et Médecine',
                        'Sciences humaines' => 'Sciences humaines',
                        'Scolaire et Parascolaire' => 'Scolaire et Parascolaire',
                        'Sports' => 'Sports',
                        'Tourisme et voyages' => 'Tourisme et voyages'
                    ],
                    'expanded' => false,
                    'multiple' => false
                ]);
            } elseif ($form_type == 'update') {
                // Formulaire d'update
                // Nothing to do...
            }
        };

        $builder
            ->add('reference', HiddenType::class, [
                'empty_data' => 'custom-' . uniqid()
            ])
            ->add('note', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    'Pas de note' => null,
                    '20' => 20,
                    '19' => 19,
                    '18' => 18,
                    '17' => 17,
                    '16' => 16,
                    '15' => 15,
                    '14' => 14,
                    '13' => 13,
                    '12' => 12,
                    '11' => 11,
                    '10' => 10,
                    '9' => 9,
                    '8' => 8,
                    '7' => 7,
                    '6' => 6,
                    '5' => 5,
                    '4' => 4,
                    '3' => 3,
                    '2' => 2,
                    '1' => 1,
                    '0' => 0                    
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'help' => 'BBCode autorisé : [b]gras[/b] - [i]italique[/i] - [u]souligné[/u] - [red]rouge[/red].',
                'attr' => [
                    'rows' => 3
                ],
                'constraints' => [
                    new Length([
                        'max' => 10000,
                        'maxMessage' => 'Maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.order_z', 'ASC');
                },
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une catégorie.'
                    ]),
                ]
            ])
            // ->add('file')
            // ->add('created_at')
            // ->add('user')
            ->addEventListener(FormEvents::PRE_SET_DATA, $listener)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'form_type' => null
        ]);
    }
}
