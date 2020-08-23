<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Profile\Edit;

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
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('firstName', Type\TextType::class, [
                'attr' => [
                    'placeholder' => 'имя',
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('lastName', Type\TextType::class, [
                'attr' => [
                    'placeholder' => 'фамилия',
                    'class' => 'form-control',
                ],
                'label' => false,
            ])
            ->add('password', Type\PasswordType::class, [
                'attr' => [
                    'placeholder' => '************',
                    'class' => 'form-control',
                ],
                'label' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
