<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('reference')
            ->add('name', TextType::class, [
                'label' => 'Intitulé (*)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Intitulé obligatoire.'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Intitulé trop court. Minimum {{ limit }} caractères.',
                        'maxMessage' => 'Intitulé trop long. Maximum {{ limit }} caractères.',
                    ])
                ]
            ])
            ->add('css', TextType::class, [
                'label' => 'Couleur CSS',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 25,
                        'minMessage' => 'Class trop courte. Minimum {{ limit }} caractères.',
                        'maxMessage' => 'Class trop longue. Maximum {{ limit }} caractères.',
                    ])
                ]
            ])
            ->add('order_z', IntegerType::class, [
                'label' => 'Ordre d\'affichage (min 1, max 50) (*)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ordre obligatoire.'
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 50,
                        'minMessage' => "L'ordre doit au moins être de {{ limit }}.",
                        'maxMessage' => "L'ordre ne doit pas être supérieur à {{ limit }}."
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
