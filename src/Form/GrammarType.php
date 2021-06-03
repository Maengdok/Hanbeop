<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Grammar;
use App\Entity\Letter;
use App\Entity\Level;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrammarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('letter', EntityType::class, [
                'class' => Letter::class,
                'label' => 'Lettre'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie'
            ])
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'label' => 'Niveau'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grammar::class,
        ]);
    }
}
