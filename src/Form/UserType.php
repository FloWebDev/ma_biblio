<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use App\Validator\Constraints\CaptchaConstraint;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listener = function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            if (is_null($user->getId())) {
                // Cas d'une inscription
                $form->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'La confirmation du mot de passe est incorrecte',
                    'required' => true,
                    'first_options'  => [
                        'label' => 'Mot de passe (entre 8 et 18 caractères, chiffres et lettres uniquement (*)',
                        'attr' => [
                            'placeholder' => 'Création du mot de passe'
                        ]
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du mot de passe (*)',
                        'attr' => [
                            'placeholder' => 'Confirmation du mot de passe'
                        ]
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Mot de passe obligatoire'
                        ]),
                        new Length([
                            'min' => 8,
                            'max' => 18,
                            'minMessage' => 'Mot de passe trop court. Minimum {{ limit }} caractères',
                            'maxMessage' => 'Mot de passe trop long. Maximum {{ limit }} caractères',
                        ])
                    ]
                ])
                ->add('captcha', IntegerType::class, [
                    'label' => 'Renseignez les 4 chiiffres présents dans l\'image (*)',
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir le nombre affiché dans l\'image.'
                        ]),
                        new Length([
                            'min'        => 4,
                            'max'        => 4,
                            'minMessage' => 'Nombre de caractères minimum attendus : {{ limit }}',
                            'maxMessage' => 'Nombre de caractères maximum attendus : {{ limit }}'
                        ]),
                        new CaptchaConstraint()
                    ]
                ]);
            } else {
                // Cas d'une modification de profil
                $form->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'La confirmation du mot de passe est incorrecte',
                    'required' => true,
                    'first_options'  => [
                        'label' => 'Modification du mot de passe (entre 8 et 18 caractères, chiffres et lettres uniquement (*)',
                        'attr' => [
                            'placeholder' => 'Nouveau mot de passe'
                        ]
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du nouveau mot de passe (*)',
                        'attr' => [
                            'placeholder' => 'Confirmation du nouveau mot de passe'
                        ]
                    ],
                    'constraints' => [
                        // La saisie d'un mot de passe n'est pas obligatoire
                        new Length([
                            'min' => 8,
                            'max' => 18,
                            'minMessage' => 'Mot de passe trop court. Minimum {{ limit }} caractères',
                            'maxMessage' => 'Mot de passe trop long. Maximum {{ limit }} caractères',
                        ])
                    ]
                ])
                    ->add('avatar', FileType::class, [
                        'label' => 'Avatar / photo de profil (PNG, JPEG)',
                    ])
                    ->add('bio', TextareaType::class, [
                        'label' => 'Votre bio',
                        'attr' => [
                            'placeholder' => "Présentez-vous.\nQuels sont vos auteurs préférés ?\nVos livres préférés ?\nRacontez ce que vous voulez :-)",
                            'rows' => 17
                        ],
                        'constraints' => [
                            new Length([
                                'max' => 2500,
                                'maxMessage' => 'Votre bio ne doit pas dépasser {{ limit }} caractères.'
                            ])
                        ]
                    ])
                    ->add('public', ChoiceType::class, [
                        'label' => 'Profil public',
                        'choices' => [
                            'Oui' => true,
                            'Non' => false,
                        ],
                        'expanded' => false,
                        'multiple' => false
                    ]);
            }
        };

        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo (*)',
                'attr' => [
                    'placeholder' => 'Lettres et chiffres uniquement (pas d\'espace)'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Pseudo obligatoire.'
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 120,
                        'minMessage' => 'Pseudo trop court. Minimum {{ limit }} caractères.',
                        'maxMessage' => 'Pseudo trop long. Maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email (*)',
                'attr' => [
                    'placeholder' => 'exemple@gmail.com'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Adresse email obligatoire'
                    ]),
                    new Email([
                        'mode' => 'loose',
                        'message' => 'L\'adresse email saisie n\'est pas valide'
                    ])
                ]
            ])
            // ->add('slug')
            // ->add('bio')
            // ->add('created_at')
            // ->add('connected_at')
            // ->add('public')
            // ->add('active')
            // ->add('role')
            ->addEventListener(FormEvents::PRE_SET_DATA, $listener);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
