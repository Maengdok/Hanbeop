<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\User;
use App\Entity\UserAnswer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'label' => 'Utilisateur'
            ])
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'label' => 'Question'
            ])
            ->add('answer', EntityType::class, [
                'class' => UserAnswer::class,
                'label' => 'Réponse'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAnswer::class,
        ]);
    }
}
