<?php

namespace App\Form;

use App\Entity\Exhibitions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExhibitionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'exposition'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description de l\'exposition'
            ])
            ->add('exhibitionsImages', FileType::class,[
                'multiple'=> true,
                'mapped' => false,
                'required' => false,
                'label' => 'Images'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exhibitions::class,
        ]);
    }
}
