<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Oeuvre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'constraints' => [
                    new NotBlank([
                        "message" => "Le nom est obligatoire"
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        "message" => "La description est obligatoire"
                    ])
                ]
            ])
            ->add('image', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez rentrer une URL d'image"
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "La catégorie de l'oeuvre est obligatoire"
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
            'constraints' => [
                new UniqueEntity(['fields' => ['name'],
                    'message' => 'Cette oeuvre a déjà été enregistrée '])
            ],
        ]);
    }

}
