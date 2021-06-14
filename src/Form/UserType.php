<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('roles', CollectionType::class, [
                'label' => 'Rôles',
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'label' => ' ',
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Premium' => 'ROLE_PREMIUM',
                        'Professeur' => 'ROLE_PROFESSOR',
                        'Admin' => 'ROLE_ADMIN'
                    ]
                ]
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo'
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('fname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('civility', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => [
                    'M.' => 1,
                    'Mme.' => 2,
                    'Mlle.' => 3
                ]
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Date de naissance',
                'format' => 'dd MMMM yyyy',
            ])
             ->add('subscription', ChoiceType::class, [
                'label' => 'Abonnement',
                'choices' => [
                    'Non' => null,
                    'Oui' => true
                ]
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
