<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\SignUp\Email\Request;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('email', Type\EmailType::class, [
                'attr' => [
                    'placeholder' => 'email',
                    'class' => 'auth',
                ],
                'label' => false,
            ])
            ->add('firstName', Type\TextType::class, [
                'attr' => [
                    'placeholder' => 'имя',
                    'class' => 'auth',
                ],
                'label' => false,
            ])
            ->add('lastName', Type\TextType::class, [
                'attr' => [
                    'placeholder' => 'фамилия',
                    'class' => 'auth',
                ],
                'label' => false,
            ])
            ->add('password', Type\PasswordType::class, [
                'attr' => [
                    'placeholder' => 'пароль',
                    'class' => 'auth',
                ],
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
            'csrf_protection' => true,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
