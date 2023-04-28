<?php

namespace App\Form\Type;

use Manual\Entity\Question;
use Manual\Entity\Questionnaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text')
//            ->add('questionnaire', EntityType::class, [
//                'class' => Questionnaire::class,
//                'choice_label' => 'title'
//            ])
            ->add(
                'options',
                CollectionType::class,
                [
                    'entry_type' => OptionType::class,
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
            'data_class' => Question::class,
        ]);
    }
}
