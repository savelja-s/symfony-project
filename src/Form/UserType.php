<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'required' => true
            ])
            ->add('email', EmailType::class,[
                'required' => true
            ])
//            ->add('image', TextType::class)
            ->add('password', PasswordType::class,[
                'mapped' => false,
                'required' => true
            ])
            ->add('status', NumberType::class,[
                'required' => true
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_USER',
                    'ROLE_ADMIN',
                    'ROLE_MANAGER',
                ],
                'multiple' => true,
                'mapped' => false,
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
