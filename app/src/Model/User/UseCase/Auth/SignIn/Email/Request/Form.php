<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Auth\SignIn\Email\Request;

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
            'csrf_token_id' => 'authenticate',
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
