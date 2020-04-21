<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('topic', ChoiceType::class, [
                'label' => 'Topic (*)',
                'required' => true,
                'choices' => [
                    'FAQ' => 'faq',
                    'Home col.1' => 'index1',
                    'Home col.2' => 'index2',
                    'Mentions légales' => 'mentions_legales'
                ],
                'expanded' => false,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un topic.',
                    ])
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new Length([
                        'max' => 120,
                        'maxMessage' => 'Le titre ne doit pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Contenu',
                'help' => 'BBCode autorisé : [b]gras[/b] - [i]italique[/i] - [u]souligné[/u] - [red]rouge[/red].',
                'attr' => [
                    'placeholder' => "lorem ipsum",
                    'rows' => 7
                ],
                'constraints' => [
                    new Length([
                        'max' => 7000,
                        'maxMessage' => 'Le contenu ne doit pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('order_z', IntegerType::class, [
                'label' => 'Ordre d\'affichage (min 1, max 50) (*)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ordre obligatoire'
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 50,
                        'minMessage' => "L'ordre doit au moins être de {{ limit }}.",
                        'maxMessage' => "L'ordre ne doit pas être supérieur à {{ limit }}."
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
