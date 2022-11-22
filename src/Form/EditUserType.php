<?php

namespace App\Form;


use App\Entity\Users;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alias', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom d\'artiste'
            ])
            ->add('description', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Description'
            ])
            ->add('image', FileType::class,[
                'mapped' => false,
                'required' => false,
                'label'=> 'Image de profile'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Editeur' => 'ROLE_EDITOR',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
            ])
            ->add('isVisible',ChoiceType::class, [
                'choices' => [
                    'Visible' => true,
                    'Invisible' => false,
                ],
                'label' => 'Profil visible'
            ])
            ->add('isVerified',ChoiceType::class, [
                'choices' => [
                    'Vérifié' => true,
                    'Non vérifié' => false,
                ],
                'label' => 'Email vérifié'
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}