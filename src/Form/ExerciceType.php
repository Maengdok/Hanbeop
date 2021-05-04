<?php

namespace App\Form;

use App\Entity\Exercice;
use App\Entity\Grammar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TypeTextType::class, [
                'label' => 'Titre'
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Créé le'
            ])
            ->add('isPremium', CheckboxType::class, [
                'label' => 'Premium ?'
            ])
            ->add('difficulty', IntegerType::class, [
                'label' => 'Difficulté'
            ])
            ->add('grammar', EntityType::class, [
                'class' => Grammar::class,
                'label' => 'Grammaire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exercice::class,
        ]);
    }
}
