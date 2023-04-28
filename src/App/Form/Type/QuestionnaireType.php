<?php

namespace App\Form\Type;

use Manual\Entity\ProductCategory;
use Manual\Entity\Questionnaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('productCategory', EntityType::class, [
                'class' => ProductCategory::class,
            ])
            ->add(
                'questions',
                CollectionType::class,
                [
                    'entry_type' => QuestionType::class,
                    'allow_add' => true,
                    'prototype' => true,
                    'entry_options' => [
                        'label' => false,
                    ],
                    'by_reference' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
        ]);
    }
}
